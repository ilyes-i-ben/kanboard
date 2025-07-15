document.addEventListener('DOMContentLoaded', function() {
    var addBtn = document.getElementById('add-category');
    var list = document.getElementById('categories-list');
    addBtn.addEventListener('click', function() {
        var inputs = list.querySelectorAll('input[name="categories[]"]');
        if (inputs.length > 0 && inputs[inputs.length - 1].value.trim() === '') {
            inputs[inputs.length - 1].focus();
            return;
        }
        var div = document.createElement('div');
        div.className = 'flex items-center gap-2 mb-2';
        div.innerHTML = '<input type="text" name="categories[]" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Category name" />' +
            '<button type="button" class="remove-category rounded-full p-2 text-red-400 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition" title="Remove"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>';
        list.appendChild(div);
        updateRemoveButtons();
    });
    list.addEventListener('click', function(e) {
        var btn = e.target.closest('.remove-category');
        if (btn) {
            btn.parentElement.remove();
            updateRemoveButtons();
        }
    });
    function updateRemoveButtons() {
        var btns = list.querySelectorAll('.remove-category');
        btns.forEach(function(btn, idx) {
            btn.style.display = (list.children.length > 1) ? '' : 'none';
        });
    }
});
