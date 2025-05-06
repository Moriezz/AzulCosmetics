document.getElementById('insertProductBtn').addEventListener('click', function() {
    showSection('insert_product');
});

document.getElementById('viewCategoriesBtn').addEventListener('click', function() {
    showSection('view_categories');
});

function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.container').forEach(function (container) {
        container.classList.add('hidden');
    });

    // Show the selected section
    document.getElementById(sectionId).classList.remove('hidden');
}