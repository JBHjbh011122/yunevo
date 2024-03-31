// JavaScript pour ouvrir et fermer la navigation
document.getElementById('openNav').addEventListener('click', function() {
    // Lorsque l'élément avec l'ID 'openNav' est cliqué, affiche la navigation mobile en tant que flexbox.
    document.getElementById('mobileNav').style.display = 'flex';
});

document.getElementById('closeNav').addEventListener('click', function() {
    // Lorsque l'élément avec l'ID 'closeNav' est cliqué, masque la navigation mobile.
    document.getElementById('mobileNav').style.display = 'none';
});



document.querySelectorAll('.clickable-row').forEach(row => {
    row.addEventListener('click', function (event) {
        if (!event.target.closest('.form-check-input')) {
            console.log('Row clicked:', this.dataset.href);
            window.location.href = this.dataset.href;
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.form-check-input');
    const deleteSelectedButton = document.getElementById('deleteSelected');
    const selectAllButton = document.getElementById('selectAll');

    // Изначально скрываем кнопку "Выбрать все"
    selectAllButton.style.display = 'none';

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            // Проверяем, выбран ли хоть один чекбокс
            const anyChecked = Array.from(checkboxes).some(c => c.checked);

            // Показываем или скрываем кнопки в зависимости от выбора
            deleteSelectedButton.style.display = anyChecked ? 'inline-block' : 'none';
            selectAllButton.style.display = anyChecked ? 'inline-block' : 'none';
        });
    });

    // Обработчик клика по кнопке "Выбрать все"
    selectAllButton.addEventListener('click', function() {
        const isAnyUnchecked = Array.from(checkboxes).some(c => !c.checked);
        checkboxes.forEach(checkbox => {
            checkbox.checked = isAnyUnchecked;
        });

        // Переключаем видимость кнопки "Удалить"
        // Кнопка "Выбрать все" остается видимой, если есть выбранные чекбоксы
        deleteSelectedButton.style.display = isAnyUnchecked ? 'inline-block' : 'none';
    });
});






function updateFileName() {
    var input = document.getElementById('photo_profil');
    var label = document.getElementById('label-photo-profil');
    if (input.files && input.files.length > 0) {
        label.textContent = input.files[0].name;
    }
}

