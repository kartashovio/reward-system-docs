function themeToggle(){
    let themeCss = document.querySelector(".theme");
    if(themeCss !== null){
        if(!window.isDocsifyDarkMode) {
            window.isDocsifyDarkMode = true;
            themeCss.setAttribute("href", "https://cdn.jsdelivr.net/npm/docsify-themeable@0/dist/css/theme-simple-dark.css");
            updateCustomCSS();
        }
        else{
            window.isDocsifyDarkMode = false;
            themeCss.setAttribute("href", "https://cdn.jsdelivr.net/npm/docsify-themeable@0/dist/css/theme-simple.css");
            updateCustomCSS();
        }
    }
}

function updateCustomCSS() {
    let tableBars = document.querySelectorAll('.markdown-section tr:nth-child(2n)');
    if (tableBars !== null) {
        for (var i = 0; i < tableBars.length; ++i)
        tableBars[i].style.backgroundColor = window.isDocsifyDarkMode ? "#363636" : "#f8f8f8";
    }
}
window.updateCustomCSS = updateCustomCSS;