<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<script src="http://test.api.its-mo.com/cgi/loader.cgi?key=JSZ752c40ded32d&ver=2.0&api=zdcmap.js,search.js,shape.js&enc=EUC&force=1" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[

    var map,
        lat = 35.6778614, lon = 139.7703167, latlon = new ZDC.LatLon(lat, lon);

    function loadMap() {

        map = new ZDC.Map(
        document.getElementById('ZMap'),{
            latlon : new ZDC.LatLon(lat, lon),
            zoom : 8
        });

        var center = new ZDC.MapCenter();
        map.addWidget(center);
    };

    /* 検索ボタン */
    function searchClick(){
        var word = document.getElementById('word').value;
        if (word == '') {
            return;
        } else {
            execSearch(word);
        }
    };

    /* 検索成功時の処理 */
    function execSearch(word){

        ZDC.Search.getStationByWord({word : word}, function(status, res){
            if (status.code == '000') {
                initTable();
                writeTable(res);
            } else {
                /* 取得失敗 */
                alert(status.text);
            }
        });
    };

    /* 駅検索結果テーブル作成 */
    function initTable() {
        var element = document.getElementById('search-result');
        while (element.firstChild) {
          element.removeChild(element.firstChild);
        }
    };

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
    };

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

        });

        td.appendChild(div);
        tr.appendChild(td);
        return tr;
    };

    var from, to;
    var select_eki_latlon = {}, imgdir ='../../image/search/';
    var guyde_type = {
        'start': {
            custom: {
                base: {
                    src: imgdir + 'route_bg.png',
                    imgSize: new ZDC.WH(35, 35),
                    imgTL: new ZDC.TL(0, 0)
                },
                content: {
                    src: imgdir + 'route_cat.png',
                    imgSize: new ZDC.WH(35, 35),
                    imgTL: new ZDC.TL(0, 0)
                }
            },
            offset: ZDC.Pixel(0, -36)
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
        '通常通路':   {strokeColor: '#3000ff', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '横断歩道':   {strokeColor: '#008E00', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '横断通路':   {strokeColor: '#007777', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '歩道橋':     {strokeColor: '#880000', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '踏切内通路': {strokeColor: '#008800', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '連絡通路':   {strokeColor: '#000088', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '建物内通路': {strokeColor: '#550000', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '敷地内通路': {strokeColor: '#005500', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '乗換リンク': {strokeColor: '#000055', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '道路外':     {strokeColor: '#110000', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '引き込みリンク':{strokeColor: '#FF0000', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'},
        '通路外':{strokeColor: '#00FF00', strokeWeight: 5, lineOpacity: 0.5, lineStyle: 'solid'}
    };

    var mode;
    /* ルート探索ボタン */
    function routeClick() {

        from = select_eki_latlon;
        to   = map.getLatLon();

        /* 歩行者ルート探索を実行 */
        ZDC.Search.getRouteByWalk({
            from: from,
            to: to
        },function(status, res) {
            if (status.code == '000') {
                /* 取得成功 */
                removeAllWidget();
                writeRoute(status, res);
            } else {
                /* 取得失敗 */
                alert(status.text);
            }
        });
    };

    var pl = [];
    var mk = [];
    /* ルートを描画します */
    function writeRoute(status, res) {

        /* スタートとゴールのアイコンを地図に重畳します */
        setStartEndWidget();

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
    };

    var start, end;
    /* スタートとゴールのアイコンを地図に重畳します */
    function setStartEndWidget() {

        start = new ZDC.Marker(from, guyde_type["start"]);
        end   = new ZDC.Marker(to, guyde_type["end"]);

        /*
         *  スタートとゴールのウィジットが他のマーカの
         *  下にならないようにz-indexを設定します
         */
        start.setZindex(110);
        end.setZindex(110);

        map.addWidget(start);
        map.addWidget(end);
    };

    var msg_info;
    /* マーカクリックイベント */
    function markerClick() {

        var html = '<div style = "width:200px; height:50px;">';
        html += '<table border="1" style="width:180px;">';
        html += '<tr><td width="35%" style="font-size:10pt;">通路種別</td><td style="font-size:10pt;">' + this.link.structureType + '</td></tr>';
        html += '<tr><td style="font-size:10pt;">構造種別</td><td style="font-size:10pt;">'+ this.link.type +'</td></tr></tbody></table></div>';
        if (typeof msg_info != 'undefined') {
            map.removeWidget(msg_info);
        }
        msg_info = new ZDC.MsgInfo(
                this.link.line[0],
                {html: html}
                );
        map.addWidget(msg_info);
        msg_info.open();
    };

    function removeAllWidget(){

        for (var i=0,l=pl.length; i<l; i++) {
            pl[i].removeAllPoints();
            pl[i].redraw();
        }
        pl = [];

        for (i = 0,l = mk.length; i < l; i++) {
            map.removeWidget(mk[i]);
        }
        mk = [];

        for (var i=0,l=pl.length; i<l; i++) {
        }

        if (typeof msg_info != 'undefined') {
            map.removeWidget(msg_info);
        }

        if (typeof start != 'undefined') {
            map.removeWidget(start);
        }

        if (typeof end != 'undefined') {
            map.removeWidget(end);
        }
    };

//]]>
</script>

<style>
div.eki-list:hover{
    background-color: #C8FFFF;
}
</style>
</head>

<body onload="loadMap();">
    <div id="ZMap" style="border:1px solid #777777; width:500px; height:300px; top:200px; left:20px; position:absolute;"></div>
    <div id="search-area" style="width:600px; height:175px; top:0px; left:20px; position:absolute;">
        <input type="text" id="word" value="東京">
        <input type="button" id="search-btn" value='検索' onclick='searchClick();'>
        <input type="button" id="route-btn"  value='ルート探索' onclick='routeClick();'>
        <div id="search-result" style="overflow: scroll; height: 150px">
        </div>
    </div>
</body>
</html>