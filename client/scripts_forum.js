

function loadPosts( ){
}

function loadPostsTest(tableId) {
	var table_obj = document.getElementById(tableId);
	var json_obj = '
		{
			"No": 1
			"Title": "Sample Title"
			"Author": "sample author"
			"Date": "sample date"
			"Views": "sample views"
		}
	';
	var obj = JSON.parse ();
	var html_out = "<th>" + "<td>" + obj["No"] +  "</td><td>" + obj["Title"] +  "</td><td>" + obj["Author"] +  "</td><td>" + obj["Date"] +  "</td><td>" + obj["Views"] + "</td></th>";
	table_obj.innerHTML = html_out;
}