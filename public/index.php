<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<script src="http://api.its-mo.com/cgi/loader.cgi?key=JSZ752c40ded32d&ver=2.0&api=zdcmap.js&enc=EUC&force=1" type="text/javascript"></script>

<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet">
<script src="js/bootstrap.js"></script>

<script type="text/javascript">
//<![CDATA[
    /* 東京 */
    var map,
        lat = 35.6778614, lon = 139.7703167;

    function loadMap() {
      map = new ZDC.Map(
        document.getElementById('ZMap'),
          {
            latlon: new ZDC.LatLon(lat, lon),
            zoom: 3
          }
        );
      /* 地図をクリックしたときの動作 */
      ZDC.addListener(map, ZDC.MAP_CLICK, getClickLatLon);
      var center = new ZDC.MapCenter();
       map.addWidget(center);
    };

    function zoomIn() {
      map.zoomIn();
    }

    function zoomOut() {
      map.zoomOut();
    }
    var isBeginPoint = true, beginLatLon, endLatLon;
    /* クリックした地点の緯度経度を表示する */
    function getClickLatLon() {
      var latlon =  map.getClickLatLon();
      // alert('');
      markerDisp(isBeginPoint, latlon);
      if (isBeginPoint) {
        beginLatLon = latlon;
        isBeginPoint = false
        alert(status.text);
      } else {
        endLatLon = latlon;
        alert(status.text);
        routeClick();
      }
    };

    function markerDisp(isBeginPoint, latlon) {
      var itemlatlon = new ZDC.LatLon(latlon.lat, latlon.lon);
      var marker = new ZDC.Marker(itemlatlon)
      map.addWidget(marker);
    }

    // search route -----------------------------------------
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

        from = map.getLatLon();
        to   = map.getLatLon();
        alert(status.text);
        /* 歩行者ルート探索を実行 */
        ZDC.Search.getRouteByWalk({
            from: from,
            to: to
        },function(status, res) {
            if (status.code == '000') {
                /* 取得成功 */
                removeAllWidget();
                alert(status.text);
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
</head>

<body onload="loadMap();">
  <div id="ZMap" style="min-width: 100%; min-height: 100%; z-index: -1; position: absolute;"></div>
  <form action="">
    <input type="text" name="inputForSearch" maxlength="256" placeholder="住所" style="width: 16%; height: 2.5%; position: absolute;">
  </form>
<!--   <button type="button" style="border-radius: 48px; border-color: #FFFFFF;background-color: #00D5FF; font-size: 24px;" id="search_route_btn" onclick="">
    ルート探索
  </button> -->
  <br>
  <button type="button" style="width: 48px; height: 48px; border-radius: 48px; border-color: #FFFFFF;background-color: #00D5FF; font-size: 24px;" id="zoom_in_btn" onclick="zoomIn()">
    +
  </button>
  <br>
  <button type="button" style="width: 48px; height: 48px; border-radius: 48px; border-color: #FFFFFF;background-color: #00D5FF; font-size: 24px;" id="zoom_out_btn" onclick="zoomOut()">
    -
  </button>
  <h4 style="width: 32%; text-align:center; background-color: #00D5FF; border-style: solid; border-width: 4px; border-radius: 48px; border-color: #00D5FF;">
    touch the map to set begin point
  </h4>
</body>
</html>