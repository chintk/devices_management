$(function() {
  $('.datepicker').datepicker({
    orientation: 'top auto',
    format: 'yyyy-mm-dd'
  });

  $('#attribute_id').change(function(){
    var attribute_id = $(this).find('option:selected').val();
    $.ajax({
      type: "GET",
      url: "/device_management/admin/device/setselectattribute",
      data: {"id": attribute_id},
      contentType: "application/json;charset=utf-8",
      dataType: "json",
      success: function (result) {
        $("#value_id").html(result);
      }
    });
  });

  $('#institute_id').change(function(){
    var institute_id = $(this).find('option:selected').val();
    $.ajax({
      type: "GET",
      url: "/device_management/admin/room/setselectdepartment",
      data: {"id": institute_id},
      contentType: "application/json;charset=utf-8",
      dataType: "json",
      success: function (result) {
        $("#department_id").html(result);
      }
    });
  });

  $('#type').change(function(){
    var type = $(this).find('option:selected').val();
    $.ajax({
      type: "GET",
      url: "/device_management/admin/device/setselecttype",
      data: {"id": type},
      contentType: "application/json;charset=utf-8",
      dataType: "json",
      success: function (result) {
        $("#name").html(result);
      }
    });
  });
});
