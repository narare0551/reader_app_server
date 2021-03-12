<script>
   $(document).ready(function(){
        get_img(0);
   });
   var i = 0;
   function get_img(index){
       var img = ["0.jpg","1.jpg","2.jpg","3.jpg","4.jpg"];
        $("#img").attr("src",img[index]); 
        i++;
        if(i == img.length){
           i=0;
       }
        setTimeout(function(){
            get_img(i);
        }, 3000);
   }
    
</script>
