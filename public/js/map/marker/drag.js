var difLat,
    difLon,
    isDragging = false;

/* マウスダウンイベント処理 */
function onMouseDown() {
    /* マウスダウン位置の緯度経度とマーカの緯度経度の差分を保持 */
    var cLatLon = map.getPointerPosition();
    isDragging = true;
    difLat = cLatLon.lat - endMarker.getLatLon().lat;
    difLon = cLatLon.lon - endMarker.getLatLon().lon;
}

/* マウスムーブイベント処理 */
function onMouseMove() {
    /* ドラッグ中のみ処理させる */
    if(isDragging) {
        var latlon = map.getPointerPosition();

        /* マーカ表示緯度経度を取得 */
        var mkLat = latlon.lat - difLat;
        var mkLon = latlon.lon - difLon;
        var mkrLatLon = new ZDC.LatLon(mkLat, mkLon);
        endMarker.moveLatLon(mkrLatLon);
    }
}

/* マウスアップイベント処理 */
function onMouseUp() {
    if(isDragging) {
        isDragging = false;
        searchRoute();
    }
}