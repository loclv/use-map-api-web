var msg_info;
/* マーカクリックイベント */
function markerClick() {
    var html = '<div style = "width: 256px; height: 112px;">';
    html += '<table class="table" border="2" style="width: 180px;">';
    html += '<tr class="success"><td width="35%" style="font-size: 12pt;">通路種別</td><td style="font-size: 12pt;">' +
        this.link.structureType + '</td></tr>';
    html += '<tr class="info"><td style="font-size: 12pt;">構造種別</td><td style="font-size: 12pt;">' +
        this.link.type + '</td></tr></tbody></table></div>';
    if (typeof msg_info != 'undefined') {
        map.removeWidget(msg_info);
    }
    msg_info = new ZDC.MsgInfo(
            this.link.line[0],
            {html: html}
            );
    map.addWidget(msg_info);
    msg_info.open();
}