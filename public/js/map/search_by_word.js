// ----------------------------------------------------
/* 検索ボタン */
function searchByWordClick() {
    var word = document.getElementById('input_text').value;
    if (word == '') {
        return;
    } else {
        execSearch(word);
    }
}

/* 検索成功時の処理 */
function execSearch(word) {
    NProgress.set(0.0);
    ZDC.Search.getStationByWord({word : word}, function(status, res){
        if (status.code == '000') {
            initTable();
            writeTable(res);
            document.getElementById('search-result').style.display = "block";
            document.getElementById('search-btn').style.backgroundColor = '#00D5FF';
            document.getElementById('search-btn').innerHTML = 'クリア';
            document.getElementById('search-btn').onclick = clearResultTable;
        } else {
            /* 取得失敗 */
            document.getElementById("dialogOutputText").innerHTML = status.text;
            $("#myModal").modal("show");
        }
    });
    NProgress.set(1.0);
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

    for (var i=0, l=item.length; i<l; i++) {

        var tbody = document.createElement('tbody');
        var tr = createTr(item[i].poi.text, item[i].poi.latlon);
        tbody.appendChild(tr);
        table.appendChild(tbody);
        table.style.backgroundColor = '#00D5FF';
        table.style.height = 148 + "px";
        table.style.bottom = 40 + "px";
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
        searchResultMarker.moveLatLon(latlon);
        searchResultMarker.visible();
    });

    td.appendChild(div);
    tr.appendChild(td);
    return tr;
}

function clearResultTable () {
    document.getElementById('search-result').style.display = "none";
    document.getElementById('search-btn').style.backgroundColor = '#0B3B0B';
    document.getElementById('search-btn').innerHTML = '検索';
    document.getElementById('search-btn').onclick = searchByWordClick;
}