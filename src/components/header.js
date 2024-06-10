let lastScrollTop = 0; 
const header = document.getElementById('header');

window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop || document.body.scrollTop || 0;
    if (scrollTop > lastScrollTop){
        // Down Scroll
        header.classList.add('nav-up');
        header.classList.remove('nav-down');
    } else {
        // Up Scroll
        header.classList.add('nav-down');
        header.classList.remove('nav-up')
    }
    lastScrollTop = scrollTop;
});