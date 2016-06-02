var scalebarWidget,
    isScalebarAppear = false;
function showScaleBar() {
    if (isScalebarAppear == false) {
        /* スケールバーを作成 */
        scalebarWidget = new ZDC.ScaleBar();

        map.addWidget(scalebarWidget);
        isScalebarAppear = true
        document.getElementById("show_scale_var_menu_list").style.display = "none";
        document.getElementById("hide_scale_var_menu_list").style.display = "block";
    }
}

function hideScaleBar() {
  if (isScalebarAppear) {
    map.removeWidget(scalebarWidget);
    isScalebarAppear = false;
    document.getElementById("show_scale_var_menu_list").style.display = "block";
    document.getElementById("hide_scale_var_menu_list").style.display = "none";
  }
}