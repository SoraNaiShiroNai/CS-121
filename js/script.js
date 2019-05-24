function onr() {

  $("#viewer").click(function(){
    changeView("view");
  });
  $("#user").click(function(){
    changeView("user");
  });
  $("#admin").click(function(){
    changeView("admin");
  });

  $(".producttitle").click(function(){
    displayProdModal();
  });

  $(".addlisting").click(function(){
    displayAddListingModal();
  });

  $(".editbtn").click(function(){
    displayEditListingModal();
  });

  $(".submitadd").click(function(){
    $('#listingmod').modal('hide');
  });

  $(".submitedit").click(function(){
    $('#editmod').modal('hide');
  });
  
  $(".addbtn").click(function(){
	  $("#cartside").append( "<div class='card'> <p> <b>Product:</b> Coca Cola 350ml </p><p><b>Price:</b> P27 </p><br>" );
  });

function changeView(a) {
  if(a=="view"){
    $(".profilebtn").hide();
    $(".addbtn").hide();
    $(".editbtn").hide();
    $(".delbtn").hide();
    $(".addlisting").hide();
  }
  else if(a=="user"){
    $(".profilebtn").show();
    $(".addbtn").show();
    $(".editbtn").hide();
    $(".delbtn").hide();
    $(".addlisting").hide();
  }
  else {
    $(".profilebtn").hide();
    $(".addbtn").hide();
    $(".editbtn").show();
    $(".delbtn").show();
    $(".addlisting").show();
  }
}

function displayProdModal(){
  $("#productimg").attr("src",$("#img1").attr("src"));
  $("#producttitle").text($("#t1").text());
  $("#productdesc").text($("#d1").text());
  $("#productprice").text($("#p1").text());
  $('#productmod').modal('show');
}

function displayAddListingModal(){
  $('#listingmod').modal('show');
}

function displayEditListingModal(){
  $('#editmod').modal('show');
}

}

$(document).ready(onr);
