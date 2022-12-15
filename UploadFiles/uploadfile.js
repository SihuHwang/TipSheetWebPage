//README upload
$('#uploadfile').on("change", function() {
    var file = this.files[0];
    var fr = new FileReader();
    fr.fileName = file.name
    fr.onload = function(e) {
        e.target.result
        html = '<input type="hidden" name="data" value="' + e.target.result.replace(/^.*,/, '') + '" >';
        html += '<input type="hidden" name="mimetype" value="' + e.target.result.match(/^.*(?=;)/)[0] + '" >';
        html += '<input type="hidden" name="filename" value="' + e.target.fileName + '" >';
        $("#data").empty().append(html);
    }
    fr.readAsDataURL(file);
  });
  
  //Forensics #1 Upload
  $('#uploadfile2').on("change", function() {
    var file = this.files[0];
    var fr = new FileReader();
    fr.fileName = file.name
    fr.onload = function(e) {
        e.target.result
        html = '<input type="hidden" name="data" value="' + e.target.result.replace(/^.*,/, '') + '" >';
        html += '<input type="hidden" name="mimetype" value="' + e.target.result.match(/^.*(?=;)/)[0] + '" >';
        html += '<input type="hidden" name="filename" value="' + e.target.fileName + '" >';
        $("#data2").empty().append(html);
    }
    fr.readAsDataURL(file);
  });

  //Forensics #2 Upload
  $('#uploadfile3').on("change", function() {
    var file = this.files[0];
    var fr = new FileReader();
    fr.fileName = file.name
    fr.onload = function(e) {
        e.target.result
        html = '<input type="hidden" name="data" value="' + e.target.result.replace(/^.*,/, '') + '" >';
        html += '<input type="hidden" name="mimetype" value="' + e.target.result.match(/^.*(?=;)/)[0] + '" >';
        html += '<input type="hidden" name="filename" value="' + e.target.fileName + '" >';
        $("#data3").empty().append(html);
    }
    fr.readAsDataURL(file);
  });

   //Forensics #23 Upload
  $('#uploadfile3').on("change", function() {
    var file = this.files[0];
    var fr = new FileReader();
    fr.fileName = file.name
    fr.onload = function(e) {
        e.target.result
        html = '<input type="hidden" name="data" value="' + e.target.result.replace(/^.*,/, '') + '" >';
        html += '<input type="hidden" name="mimetype" value="' + e.target.result.match(/^.*(?=;)/)[0] + '" >';
        html += '<input type="hidden" name="filename" value="' + e.target.fileName + '" >';
        $("#data3").empty().append(html);
    }
    fr.readAsDataURL(file);
  });