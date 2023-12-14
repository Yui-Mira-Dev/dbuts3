const inputElements = document.querySelectorAll('.detail');
const radioElements = document.querySelectorAll('input[type="radio"]');
const fileUploadElement = document.getElementById('file-upload');
const resetButton = document.querySelector('input[type="reset"]');

function updateCategoryClass(input) {
    if (input.value.trim() !== '') {
        input.parentElement.querySelector('.category').classList.add('filled');
    } else {
        input.parentElement.querySelector('.category').classList.remove('filled');
    }
}

function updateRadioCategory() {
    radioElements.forEach(radio => {
        const name = radio.getAttribute('name');
        const checkedRadio = document.querySelector(`input[type="radio"][name="${name}"]:checked`);
        radioElements.forEach(radio => {
            const input = radio.parentElement.querySelector('.detail');
            if (radio === checkedRadio) {
                input.parentElement.querySelector('.category').classList.add('filled');
            } else {
                updateCategoryClass(input);
            }
        });
    });
}

inputElements.forEach(input => {
    input.addEventListener('input', function() {
        updateCategoryClass(input);
    });
});

radioElements.forEach(radio => {
    radio.addEventListener('change', function() {
        updateRadioCategory();
    });
});

fileUploadElement.addEventListener('change', function() {
    if (fileUploadElement.files.length > 0) {
        fileUploadElement.parentElement.querySelector('.category').classList.add('filled');
    } else {
        updateCategoryClass(fileUploadElement);
    }
});

resetButton.addEventListener('click', function() {
    inputElements.forEach(input => {
        input.parentElement.querySelector('.category').classList.remove('filled');
    });
    updateRadioCategory();
    updateCategoryClass(fileUploadElement);
});