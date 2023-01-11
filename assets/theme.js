function themeToggle(){
    let themeCss = document.querySelector(".theme");
    if(themeCss !== null){
        if(!window.isDocsifyLightMode) {
            window.isDocsifyLightMode = true;
            themeCss.setAttribute("href", "https://cdn.jsdelivr.net/npm/docsify-themeable@0/dist/css/theme-simple.css");
            updateCustomCSS();
        }
        else{
            window.isDocsifyLightMode = false;
            themeCss.setAttribute("href", "https://cdn.jsdelivr.net/npm/docsify-themeable@0/dist/css/theme-simple-dark.css");
            updateCustomCSS();
        }
    }
}

function updateCustomCSS() {
    let tableBars = document.querySelectorAll('.markdown-section tr:nth-child(2n)');
    if (tableBars !== null) {
        for (var i = 0; i < tableBars.length; ++i)
        tableBars[i].style.backgroundColor = window.isDocsifyLightMode ? "#f8f8f8" : "#363636";
    }
}
window.updateCustomCSS = updateCustomCSS;