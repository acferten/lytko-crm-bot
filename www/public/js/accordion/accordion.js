document.querySelectorAll('.accordion__button').forEach((element) => {
    const content = element.nextElementSibling;
    if (element.classList.contains('accordion__button--open')) {
        content.style.maxHeight = content.scrollHeight + 'px';
    }
    element.addEventListener('click', () => {
        element.classList.toggle('accordion__button--open');
        element.lastElementChild.classList.toggle('accordion__arrow--open');
        if (content.style.maxHeight !== '0px') {
            content.style.maxHeight = 0 + 'px';
        } else {
            content.style.maxHeight = content.scrollHeight + 'px';
        }
    });
})
