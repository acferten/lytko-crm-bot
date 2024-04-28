const appLayout = document.querySelector('.app');

document.querySelector('.toggle-navigation').addEventListener('click', () => {
    appLayout.classList.toggle('app--close-navigation');
})
