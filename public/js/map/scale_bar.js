var scalebarWidget;
function showScaleBar() {
    /* スケールバーを作成 */
    alert("Hello! I am an alert box!!");
    scalebarWidget = new ZDC.ScaleBar();

    map.addWidget(scalebarWidget);
}

function hideScaleBar() {
    if (scalebarWidget == 'undefined') {
        map.removeWidget(scalebarWidget);
    }
}