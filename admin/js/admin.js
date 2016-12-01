function check(checked){
	
	var v_checked = checked;
	var element_count = document.form_list.elements.length;
	//alert(element_count);
	var BgColour = "#ffffff";
	for(i=0;i<element_count;i++){
		var RowID = "tr"+i;
		if(document.form_list.elements[i].type=="checkbox" && document.form_list.elements[i].name != "SelectAll"){
		document.form_list.elements[i].checked=checked;		
		}//end if
	}
	
}//end function

function check1(checked){
//alert(checked);

var v_checked = checked;
//alert(v_checked);
var row_count = document.form_list.txt_row_count.value;
//alert(row_count);

var row_count = document.form_list.elements.length;
//alert(row_count);

var BgColour = "#ffffff";
for(j=1;j<=row_count;j++){
	
//alert(i);

/*
if(document.form_list.elements[j].type=="checkbox"){
	var i=j;	
}else {
	var i=2*j;	
}
*/

i=j;

if(document.form_list.elements[i].type=="checkbox"){

document.form_list.elements[i].checked=checked;

if(document.form_list.elements[i].type=="checkbox" && document.form_list.elements[i].name != "SelectAll"){
alert(document.form_list.elements[i].value);
//var RowID = document.form_list.elements[i].value;
var RowID = "tr"+i;
//alert(RowID);
//var BgColour = eval("tr"+RowID+".bgColor");
//document.getElementById(rowID).style.backgroundColor = oldColor;
//var BgColour = eval("tr"+RowID+".class.name");
if(v_checked){
//alert("checked");
document.getElementById(RowID).bgColor='#FFDBA6';
//eval("tr"+RowID+".style.background='#FFDBA6'");
//eval("tr"+RowID+".bgColor='#FFDBA6'");
}
else{

if(BgColour == "#ffffff"){
BgColour = "#F0F0F0";
}
else{
BgColour = "#ffffff";
}

//alert(BgColour);
document.getElementById(RowID).bgColor=BgColour;
//document.getElementById(rowID).style.backgroundColor = BgColour;
//eval("tr"+RowID+".style.background='"+BgColour+"'");
//eval("tr"+RowID+".bgColor='"+BgColour+"'");
}
//SelectDeselectRow(document.form_list.elements[i].value,true,)
}

}//end if
}//end for
}//end function

function SelectDeselectRow(RowID,CheckBoxValue,bgcolor){

var RowID = "tr"+RowID;
//alert(RowID);

if(CheckBoxValue){
//document.getElementById(RowID).bgColor='#FFDBA6';
//eval("tr"+RowID+".style.background='#FFDBA6'");
//eval("tr"+RowID+".bgColor='#FFDBA6'");
}
else{
//eval("tr"+RowID+".bgColor='"+bgcolor+"'");
//document.getElementById(RowID).bgColor=bgcolor;
//eval("tr"+RowID+".style.background='"+bgcolor+"'");
}

}//end function

function ChangeStatus(URL,Status,Message) {

var confirmdelete = window.confirm("Are you sure you want to " + Message + " the selected Record(s)?\n")
if (confirmdelete)
 {
	document.form_list.txt_status.value = Status;
	document.form_list.method="post";
	document.form_list.action=URL;
	
	document.form_list.submit();
 }
}


function ChangeStatusThis(URL,Status,Message,Table) {

var confirmdelete = window.confirm("Are you sure you want to  " + Message + " the selected Record(s)?\n")
if (confirmdelete){
document.form_list.txt_table.value=Table;
document.form_list.txt_status.value=Status;
document.form_list.method="post";
document.form_list.action=URL;
//alert(document.form_list.action)
document.form_list.submit();
}
}


function checkDelete(URL,ID){
	//alert(URL);
var confirmdelete = window.confirm("Are you sure you want to delete this project?\n")
if (confirmdelete)
 {
	//document.form_list.txt_status.value = Status;
	document.form_list.method="post";
	document.form_list.action=URL+'?id='+ID;
	
	document.form_list.submit();
 }

}
