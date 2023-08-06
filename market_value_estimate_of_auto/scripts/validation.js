//check fields
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('estimate_form');
    var errorBlock = document.getElementById('errorBlock');
    
    form.addEventListener('submit', function (event) {
        errorBlock.style.display = 'none';
        
        var selects = form.querySelectorAll('select');
        let hasEmptyField = false;
        
        selects.forEach(function (select) {
            if (!select.value) {
                hasEmptyField = true;
                return;
            }
        });
        
        if (hasEmptyField) {
            event.preventDefault();
            errorBlock.innerHTML = 'Пожалуйста, заполните все поля.';
            errorBlock.style.display = 'block';
        }
    });
});
