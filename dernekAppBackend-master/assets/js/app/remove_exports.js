$(document).ready(function(){

  async function control(){
    var count = 0;
      while(true){
          await sleep(500);
        count = $(document).find(".dt-buttons").length;
        if(count == 1){
          $(document).find(".dt-buttons").remove();
          break;
        }
      }
  }
  function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

control();

});
