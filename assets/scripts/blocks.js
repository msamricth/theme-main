let allCollapsibles = document.querySelectorAll('.collapse');

allCollapsibles.forEach(function (allCollapsible) {
    allCollapsible.addEventListener('hide.bs.collapse', event => {
        allCollapsible.classList.add('closing')
    });
    allCollapsible.addEventListener('hidden.bs.collapse', event => {

        setTimeout(() => {
            allCollapsible.classList.remove('closing');
        }, 300);

    });
});