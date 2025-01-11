$(document).ready(function() {
  $('.sections_title').click(function(){
    id = $(this).attr('id');
    x = Number(id.match(/\d+/));
    toggle_sections(x);
  });
  //toggle_fields('main');
  //toggle_sections(1);
  transtlit_url();
  
  $(document).on('change', '.check_all', function(){
    $('.row_check').each(function(){
      $(this).prop('checked', $('.check_all').prop('checked'));
    });
  });
});

function toggle_fields(x){
  $('.fields_headers').removeClass('fields_headers_act');
  $('.'+x+'_fields_btn').addClass('fields_headers_act');
  $('.fields').hide();
  $('.'+x+'_fields').show();
  $('#field_group').val(x);
}
function toggle_sections(x){
  $('.sections_title').removeClass('sections_title_act');
  $('#show_'+x+'_sections').addClass('sections_title_act');
  $('.sections_items').hide();
  $('.sections_'+x+'').show();
}
function toggle_menu(x){
  $('.sections_item').removeClass('act');
  $('.sections_item_'+x).addClass('act');
}
function transtlit_url(){
  t = $('#title').val(); 
  $.get('scripts/translit.php', { t: t }, function(data){
    if ($('#url').val()==''){
      $('#url').val(data); 
    }
  });
}
function save_changes(area,page,id,val){ 
  if (val==undefined) new_value = $('#'+area+'_'+id).val();
  else new_value = val;
  $.get('scripts/save.php', { id: id, page: page, area: area, value: new_value, action: 'save_info' }, function(data){
    if (data){
      $('#'+area+'_'+id).val(data); 
      $('#'+area+'_'+id).css('background','#66ff66').animate({backgroundColor: "transparent"}, 1000);;
    }
    else{
      $('#'+area+'_'+id).css('background','#ff4e33').animate({backgroundColor: "transparent"}, 1000);;
    }
  });
}
function save_imagename(path,table,id,area){ 
  new_value = $('#'+area).val();
  $.get('scripts/save.php', { path: path, table: table, id: id, value: new_value, action: 'save_image' }, function(data){
    if (data){
      $('#'+area).val(data); 
      $('#'+area).css('background','#66ff66').animate({backgroundColor: "#fff"}, 1000);;
    }
    else{
      $('#'+area).css('background','#ff4e33').animate({backgroundColor: "#fff"}, 1000);;
    }
  });
}
function list_rows(page,level,sort,sc,pnum,filter,search,action,id){ 
  if (search.length){}
  else
    search = $('input#search').val();
  $.get('scripts/list_rows.php', { 
    page: page,
    level: level,
    sort: sort,
    sc: sc,
    pnum: pnum,
    filter: filter,
    search: search,
    action: action,
    id: id
  }, function(data){
    $('#list_rows').html(data); 
  });
}
function delete_rows(page,level,sort,sc,pnum,filter,search,action,id){
  ids = '';
  $('.row_check').each(function(){
    if ($(this).prop('checked')==true){
      id = $(this).data('id');
      ids += id+',';
    }
  });
  $.get('scripts/list_rows.php', { 
    page: page,
    level: level,
    sort: sort,
    sc: sc,
    pnum: pnum,
    filter: filter,
    search: search,
    action: 'delete',
    id: ids
  }, function(data){
    $('#list_rows').html(data); 
  });
}
function main_image(path,file,id){
  $('#m_image_'+id).attr('src',path);
  $('#m_image').val(file);
}