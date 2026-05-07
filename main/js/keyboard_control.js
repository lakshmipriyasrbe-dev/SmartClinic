function allowNumbersOnly(e) {
    const charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        e.preventDefault();
        return false;
    }
    return true;
}

function allowLettersOnly(e) {
    const charCode = (e.which) ? e.which : e.keyCode;
    // Allow A-Z, a-z, and space
    if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 32) {
        return true;
    }
    e.preventDefault();
    return false;
}

function restrictPasteNumbers(e) {
    const input = e.target;
    // Remove any non-numeric characters
    input.value = input.value.replace(/[^0-9]/g, '');
}

function restrictPasteLetters(e) {
    const input = e.target;
    // Remove anything that isn't a letter or space
    input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
}
