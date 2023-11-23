function updateCheckedCount() {
    var checkboxes = document.querySelectorAll('.checkbox');
    var checkedCount = 0;

    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            checkedCount++;
        }
    });

    document.getElementById("checkedCount").value = checkedCount;
}