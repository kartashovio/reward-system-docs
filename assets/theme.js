function DarkMode() {
    let themeCss = document.querySelector(".theme-css");
    if (themeCss !== null) {
        if (!window.isDocsifyDarkMode) {
            window.isDocsifyDarkMode = true;
            themeCss.setAttribute("href", "https://unpkg.com/docsify/lib/themes/dark.css");
            updateCustomCSS();
        }
        else {
            window.isDocsifyDarkMode = false;
            themeCss.setAttribute("href", "https://unpkg.com/docsify/lib/themes/vue.css");
            updateCustomCSS();
        }
    }
}
function updateCustomCSS(){
    let bar = document.querySelectorAll('.markdown-section tr:nth-child(2n)');
    if (bar !== null) {
        for (var i = 0; i < bar.length; ++i)
        bar[i].style.backgroundColor = window.isDocsifyDarkMode ? "#363636" : "#f8f8f8";
    }
}
window.updateCustomCSS = updateCustomCSS;