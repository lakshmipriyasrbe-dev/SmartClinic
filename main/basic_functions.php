<?php
    include_once("config.php");
    include_once("label.php");
    
    class Basic_Functions extends Database {
        public $con;
        
        public function __construct() {
            $this->con = $this->connect();
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }

        public function InsertSQL($table, $data, $custom_id = '', $unique_number = '', $action = '') {
            $con = $this->con;
            $last_insert_id = "";

            if (!empty($data)) {
                $columns = array_keys($data);
                $placeholders = array_fill(0, count($data), "?");
                
                $sql = "INSERT INTO $table (" . implode(",", $columns) . ") VALUES (" . implode(",", $placeholders) . ")";
                $stmt = $con->prepare($sql);
                
                if ($stmt->execute(array_values($data))) {
                    $last_insert_id = $con->lastInsertId();
                    
                    if (!empty($custom_id) && is_numeric($last_insert_id)) {
                        $custom_id_value = date("dmYhis") . "_" . str_pad($last_insert_id, 2, "0", STR_PAD_LEFT);
                        $custom_id_value = $this->encode_decode('encrypt', $custom_id_value);
                        
                        $update_data = [$custom_id => $custom_id_value];
                        
                        if (!empty($unique_number)) {
                            $last_record_id = $this->getLastRecordIDFromTable($table);
                            $unique_number_value = $this->automate_number($table, $unique_number, $last_record_id, $last_insert_id);
                            if (!empty($unique_number_value)) {
                                $unique_number_value = $this->encode_decode('encrypt', strtoupper($unique_number_value));
                                $update_data[$unique_number] = $unique_number_value;
                            }
                        }
                        
                        $this->UpdateSQL($table, $update_data, "id = ?", [$last_insert_id]);
                        $this->add_log($table, $last_insert_id, $sql, $action);
                    } else {
                        $this->add_log($table, $last_insert_id, $sql, $action);
                    }
                } else {
                    $last_insert_id = "Unable to insert the data";
                }
            }
            return $last_insert_id;
        }

        public function UpdateSQL($table, $data, $where_clause, $where_params = []) {
            $con = $this->con;
            $set_parts = [];
            foreach (array_keys($data) as $column) {
                $set_parts[] = "$column = ?";
            }
            
            $sql = "UPDATE $table SET " . implode(", ", $set_parts) . " WHERE $where_clause";
            $stmt = $con->prepare($sql);
            
            $params = array_merge(array_values($data), $where_params);
            if ($stmt->execute($params)) {
                $rowCount = $stmt->rowCount();
                // For updates, we often log differently, but for now:
                $this->add_log($table, 'Multiple/Where', $sql, 'UPDATE');
                return $rowCount;
            }
            return false;
        }

        public function getLastRecordIDFromTable($table) {
            $stmt = $this->con->prepare("SELECT id FROM $table ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            return $stmt->fetchColumn() ?: 0;
        }

        public function automate_number($table, $field, $last_id, $current_id) {
            $prefixes = [
                $GLOBALS['user_table'] => "USR",
                $GLOBALS['company_table'] => "CMP",
                $GLOBALS['consultant_table'] => "DOC",
                $GLOBALS['appointment_table'] => "APT"
            ];
            
            $prefix = $prefixes[$table] ?? "SC";
            return $prefix . "-" . str_pad($current_id, 5, "0", STR_PAD_LEFT);
        }

        public function encode_decode($action, $string) {
            $salt = $GLOBALS['salt'] ?? "default_salt";
            $key = hash('sha256', $salt);
            $iv = substr(hash('sha256', $salt), 0, 16);

            if ($action == 'encrypt') {
                return base64_encode(openssl_encrypt($string, "AES-256-CBC", $key, 0, $iv));
            } else if ($action == 'decrypt') {
                return openssl_decrypt(base64_decode($string), "AES-256-CBC", $key, 0, $iv);
            }
            return $string;
        }

        public function add_log($table, $id, $query, $action) {
            $log_dir = __DIR__ . '/logs';
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
            
            $log_file = $log_dir . '/activity_log.csv';
            $file_exists = file_exists($log_file);
            
            $handle = fopen($log_file, 'a');
            
            // Add header if new file
            if (!$file_exists) {
                fputcsv($handle, ['Timestamp', 'Table', 'Record ID', 'User', 'Action', 'Query']);
            }
            
            $user = $_SESSION['username'] ?? 'Guest/System';
            $timestamp = date('Y-m-d H:i:s');
            
            fputcsv($handle, [$timestamp, $table, $id, $user, $action, $query]);
            fclose($handle);
            
            return true;
        }
    }
?>