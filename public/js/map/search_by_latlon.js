var searchByLatlonMrkArr = [];

function searchShop() {
    searchByLatlon('0014000180');
}

function searchGas() {
    searchByLatlon('0011000130');
}

function searchByLatlon (codeString) {
    var latlonForSearch;
    latlonForSearch = new ZDC.LatLon(35.6863166, 139.695047)
    if (isBeginPoint) {
        latlonForSearch = endMarker.getLatLon();
    } else {
        latlonForSearch = beginMarker.getLatLon();
    }
    /* 緯度経度で周辺のPOI探索を実行 */
    /* ジャンルコード（コンビニ：0014000180） */
    ZDC.Search.getPoiByLatLon({
        latlon: latlonForSearch,
        genrecode: codeString,
        limit: '256'
    },function(status, res) {
        if (status.code == '000') {
            /* 取得成功 */
            markerDisp(status, res);
        } else {
            /* 取得失敗 */
            document.getElementById("dialogOutputText").innerHTML = status.text;
            $("#myModal").modal("show");
        }
    });

}

function markerDisp(status, res) {
        /* マーカを作成 */
        var items = res.item;
        var latlons = [];
        for (var i=0, j=items.length; i<j; i++) {

            var itemlatlon = new ZDC.LatLon(items[i].poi.latlon.lat, items[i].poi.latlon.lon);

            latlons.push(itemlatlon);

            var mrk = new ZDC.Marker(itemlatlon,
                {
                    color: ZDC.MARKER_COLOR_ID_GREEN_S
                });
            map.addWidget(mrk);
            searchByLatlonMrkArr.push(mrk);

            /* マーカをクリックしたときの動作 */
            ZDC.bind(mrk, ZDC.MARKER_CLICK, items[i].poi, markerClick); 

        }

        /* 地点が全て表示できる縮尺レベルを取得 */
        var adjust = map.getAdjustZoom(latlons);
        map.moveLatLon(adjust.latlon);
        // map.setZoom(adjust.zoom);
    };

function deleteMarkerSearchByLatlon() {
    /* マーカを削除 */
    while(searchByLatlonMrkArr.length > 0){
        map.removeWidget(searchByLatlonMrkArr.shift());
    }
    /* 吹き出しを閉じる */
    msg.close();
};