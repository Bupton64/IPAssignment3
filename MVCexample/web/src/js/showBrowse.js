function showBrowse() {
	 	var stock = document.getElementById("stock").checked;
	 	var powerT = document.getElementById("powerT").checked;
	 	var spades = document.getElementById("spades").checked;
	 	var hammer = document.getElementById("hammer").checked;
	 	var paintB = document.getElementById("paintB").checked;

        

        xmlhttp=new XMLHttpRequest();


        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                document.getElementById("browse-result").innerHTML=this.responseText;

            }
        }

        xmlhttp.open("GET","browseQuery.php?stock="+stock+"&powerT="+powerT+"&spades="+spades+"&hammer="+hammer+"&paintB="+paintB,true);

        xmlhttp.send();
    }