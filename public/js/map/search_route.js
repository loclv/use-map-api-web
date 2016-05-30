var line_property = {
    '通常通路':   {strokeColor: '#3000ff', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '横断歩道':   {strokeColor: '#008E00', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '横断通路':   {strokeColor: '#007777', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '歩道橋':     {strokeColor: '#880000', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '踏切内通路': {strokeColor: '#008800', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '連絡通路':   {strokeColor: '#000088', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '建物内通路': {strokeColor: '#550000', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '敷地内通路': {strokeColor: '#005500', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '乗換リンク': {strokeColor: '#000055', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '道路外':     {strokeColor: '#110000', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '引き込みリンク':{strokeColor: '#FF0000', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'},
    '通路外':{strokeColor: '#00FF00', strokeWeight: 8, lineOpacity: 0.5, lineStyle: 'solid'}
};

/* ルート探索ボタン */
function searchRoute() {
    NProgress.set(0.0);

    /* 歩行者ルート探索を実行 */
    ZDC.Search.getRouteByWalk({
        from: beginMarker.getLatLon(),
        to: endMarker.getLatLon()
    },function(status, res) {
        if (status.code == '000') {
            /* 取得成功 */
            removeAllRoute();
            writeRoute(status, res);
        } else {
            /* 取得失敗 */
            document.getElementById("dialogOutputText").innerHTML = status.text;
            $("#myModal").modal("show");
        }
    });
    NProgress.set(1.0);
}

var pl = [],
    mk = [];
/* ルートを描画します */
function writeRoute(status, res) {
    var link = res.route.link;

    /* 現在描画しているロードタイプを保存する */
    var now_road_type;

    for (var i=0, j=link.length; i<j; i++) {
        if (i == 0) {
            now_road_type = link[i].type;
            var opt = line_property[link[i].type];
        } else {
            if (now_road_type != link[i].type) {
                var opt = line_property[link[i].type];
            }
        }
        var latlons = [];
        for (var k=0, l=link[i].line.length; k<l; k++) {
            latlons.push(link[i].line[k]);
        }
        pl[i] = new ZDC.Polyline(latlons, opt);
        map.addWidget(pl[i]);

        if (link[i].type != '通常通路') {
            var guide = link[i].type;
            var marker = new ZDC.Marker(link[i].line[0]);
            map.addWidget(marker);

            /* マーカがクリックされた時のイベントを追加します */
            ZDC.bind(marker, ZDC.MARKER_CLICK,{link:link[i]}, markerClick);
            mk.push(marker);
        }
    }
}

function removeAllRoute(){

    for (var i = 0, l = pl.length; i < l; i++) {
        pl[i].removeAllPoints();
        pl[i].redraw();
    }
    pl = [];

    for (i = 0, l = mk.length; i < l; i++) {
        map.removeWidget(mk[i]);
    }
    mk = [];

    if (typeof msg_info != 'undefined') {
        map.removeWidget(msg_info);
    }
}