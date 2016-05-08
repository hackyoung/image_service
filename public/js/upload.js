
var leno = leno || {};

leno.upload = function(files, appid) {

    var upload_url = 'http://img.leno.young/image';
    var form_data = new FormData();
    for(var i in files) {
        form_data.append(files[i].size, files[i]);
    }
    form_data.append('app_id', appid);

    var oReq = new XMLHttpRequest();
    oReq.onreadystatechange = function(e) {
        console.log(oReq.status);
    };
    oReq.onerror = function(e) {
        console.log(e);
    }
    oReq.open('POST', upload_url);
    oReq.send(form_data);
};
