function changeContainerClass(oldClass, newClass) {
    var mainContainer = document.getElementById('main-container');
    if (mainContainer) {
        mainContainer.classList.remove(oldClass);
        mainContainer.classList.add(newClass);
    }
}

export { changeContainerClass } ;