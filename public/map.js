
/* 東京 */
var map,
    lat = 35.6778614,
    lon = 139.7703167,
    latlon = new ZDC.LatLon(lat, lon),
    isBeginPoint = true,
    isSearchRouteComplete = true,
    beginLatLon = new ZDC.LatLon(lat, lon),
    endLatLon = new ZDC.LatLon(lat, lon),
    beginMarker = new ZDC.Marker(latlon, ZDC.MARKER_COLOR_ID_RED_S),
    endMarker = new ZDC.Marker(latlon, ZDC.MARKER_COLOR_ID_RED_S);

function loadMap() {

    map = new ZDC.Map(
    document.getElementById('ZMap'),{
        latlon: new ZDC.LatLon(lat, lon),
        zoom: 8
    });
    /* 地図をクリックしたときの動作 */
    ZDC.addListener(map, ZDC.MAP_CLICK, getClickLatLon);
    initBeginEndMarker();
    map.addWidget(beginMarker);
    map.addWidget(endMarker);
}
// ----------------------------------------------------
function zoomIn() {
    map.zoomIn();
}

function zoomOut() {
    map.zoomOut();
}
// ----------------------------------------------------
function initBeginEndMarker() {
    /*
    *  スタートとゴールのウィジットが他のマーカの
    *  下にならないようにz-indexを設定します
    */
    beginMarker.setZindex(110);
    endMarker.setZindex(110);
    beginMarker.setTitle("start");
    endMarker.setTitle("end")
}
/* クリックした地点の緯度経度を表示する */
function getClickLatLon() {
    if (isBeginPoint) {
        beginMarker.moveLatLon(map.getClickLatLon());
        map.addWidget(beginMarker);
        changeLabelText(isBeginPoint);
        isBeginPoint = false
    } else {
        endMarker.moveLatLon(map.getClickLatLon());
        map.addWidget(endMarker);
        searchRoute();
        changeLabelText(isBeginPoint);
        isBeginPoint = true
    }
}

function changeLabelText(isBeginPoint) {
    if (isBeginPoint) {
        document.getElementById("h4label").innerHTML =
            "touch again to chose destination point and search route";
    } else {
        document.getElementById("h4label").innerHTML =
            "touch the map to set begin point";
    }
    
}
// ----------------------------------------------------
function markerDispAt(latlon) {
    var itemlatlon = new ZDC.LatLon(latlon.lat, latlon.lon);
    var marker = new ZDC.Marker(itemlatlon, ZDC.MARKER_COLOR_ID_RED_S)
    map.addWidget(marker);
}
function defaultMarkerDisp(latlon) {
    var itemlatlon = new ZDC.LatLon(latlon.lat, latlon.lon);
    var marker = new ZDC.Marker(itemlatlon)

    map.addWidget(marker);
}
// ----------------------------------------------------
/* 検索ボタン */
function searchByWordClick(){
    var word = document.getElementById('word').value;
    if (word == '') {
        return;
    } else {
        execSearch(word);
    }
}

/* 検索成功時の処理 */
function execSearch(word){

    ZDC.Search.getStationByWord({word : word}, function(status, res){
        if (status.code == '000') {
            initTable();
            writeTable(res);
        } else {
            /* 取得失敗 */
            removeDefaultPoint();
            alert(status.text);
        }
    });
}

/* 駅検索結果テーブル作成 */
function initTable() {
    var element = document.getElementById('search-result');
    while (element.firstChild) {
        element.removeChild(element.firstChild);
    }
}

/* 駅検索結果テーブル作成 */
function writeTable(res) {

    var item = res.item;
    var table = document.createElement('table');
    table.style.width = '100%';

    for (var i=0,l=item.length; i<l; i++) {

        var tbody = document.createElement('tbody');
        var tr = createTr(item[i].poi.text,item[i].poi.latlon);
        tbody.appendChild(tr);
        table.appendChild(tbody);
    }
    document.getElementById('search-result').appendChild(table);
}

/* 駅検索結果テーブル作成 */
function createTr(text,latlon) {

    var tr = document.createElement('tr');

    /* TD作成 */
    var td   = document.createElement('td');
    var div = document.createElement('div');
    div.className = 'eki-list';

    div.style.cursor = 'pointer';

    var text = document.createTextNode(text);
    div.appendChild(text);

    /* 駅名クリック時の処理 */
    ZDC.addDomListener(div, 'click', function(){
        map.moveLatLon(latlon);

        /* クリックされた駅の緯度経度を保存 */
        select_eki_latlon = latlon;
        defaultMarkerDisp(select_eki_latlon);

    });

    td.appendChild(div);
    tr.appendChild(td);
    return tr;
}

var from, to;
var select_eki_latlon = {}, imgdir ='../../image/search/';
var guyde_type = {
    'default': {
    },
    'start': {
    },
    'end': {
        custom: {
            base: {
                src: imgdir + 'route_bg.png',
                imgSize: new ZDC.WH(35, 35),
                imgTL: new ZDC.TL(38, 0)
            },
            content: {
                src: imgdir + 'route_cat.png',
                imgSize: new ZDC.WH(35, 35),
                imgTL: new ZDC.TL(35, 0)
            }
        },
        offset: ZDC.Pixel(0, -36)
    }
};
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

    from = beginMarker.getLatLon();
    to   = endMarker.getLatLon();

    /* 歩行者ルート探索を実行 */
    ZDC.Search.getRouteByWalk({
        from: from,
        to: to
    },function(status, res) {
        if (status.code == '000') {
            /* 取得成功 */
            removeAllRoute();
            writeRoute(status, res);
        } else {
            /* 取得失敗 */
            alert(status.text);
        }
    });
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

var msg_info;
/* マーカクリックイベント */
function markerClick() {

    var html = '<div style = "width:200px; height:50px;">';
    html += '<table border="1" style="width:180px;">';
    html += '<tr><td width="35%" style="font-size:10pt;">通路種別</td><td style="font-size:10pt;">' +
        this.link.structureType + '</td></tr>';
    html += '<tr><td style="font-size:10pt;">構造種別</td><td style="font-size:10pt;">' +
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

    if (typeof start != 'undefined') {
        map.removeWidget(start);
    }

    if (typeof end != 'undefined') {
        map.removeWidget(end);
    }
}

function removeDefaultPoint() {
}