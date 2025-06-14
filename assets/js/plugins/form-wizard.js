(function () {
    "use strict";
    /*---------------------------------------------------------------------
        Fieldset
    -----------------------------------------------------------------------*/
    
    let currentTab =0;
    const ActiveTab=(n)=>{
        if(n==0){
            document.getElementById("account").classList.add("active");
            document.getElementById("account").classList.remove("done");
            document.getElementById("personal").classList.remove("done");
            document.getElementById("personal").classList.remove("active");
        }
        if(n==1){
            document.getElementById("account").classList.add("done");
            document.getElementById("personal").classList.add("active");
            document.getElementById("personal").classList.remove("done");
            document.getElementById("payment").classList.remove("active");
            document.getElementById("payment").classList.remove("done");
            document.getElementById("trata").classList.remove("done");
            document.getElementById("trata").classList.remove("active");
            document.getElementById("exa").classList.remove("done");
            document.getElementById("exa").classList.remove("active");
            document.getElementById("refe").classList.remove("done");
            document.getElementById("refe").classList.remove("active");
            document.getElementById("info").classList.remove("done");
            document.getElementById("info").classList.remove("active");





        }
        if(n==2){
            document.getElementById("account").classList.add("done");
            document.getElementById("personal").classList.add("done");
            document.getElementById("payment").classList.add("active");
            document.getElementById("payment").classList.remove("done");
             document.getElementById("trata").classList.remove("done");
            document.getElementById("trata").classList.remove("active");
            document.getElementById("exa").classList.remove("done");
            document.getElementById("exa").classList.remove("active");
            document.getElementById("refe").classList.remove("done");
            document.getElementById("refe").classList.remove("active");
            document.getElementById("info").classList.remove("done");
            document.getElementById("info").classList.remove("active");
        }
        if(n==3){
            document.getElementById("account").classList.add("done");
            document.getElementById("personal").classList.add("done");
            document.getElementById("payment").classList.add("done");
             document.getElementById("trata").classList.remove("done");
            document.getElementById("trata").classList.add("active");
            document.getElementById("exa").classList.remove("done");
            document.getElementById("exa").classList.remove("active");
            document.getElementById("refe").classList.remove("done");
            document.getElementById("refe").classList.remove("active");
            document.getElementById("info").classList.remove("done");
            document.getElementById("info").classList.remove("active");
        }

        if(n==4){
            document.getElementById("account").classList.add("done");
            document.getElementById("personal").classList.add("done");
            document.getElementById("payment").classList.add("done");
             document.getElementById("trata").classList.add("done");
            document.getElementById("exa").classList.remove("done");
            document.getElementById("exa").classList.add("active");
            document.getElementById("refe").classList.remove("done");
            document.getElementById("refe").classList.remove("active");
            document.getElementById("info").classList.remove("done");
            document.getElementById("info").classList.remove("active");
        }

         if(n==5){
            document.getElementById("account").classList.add("done");
            document.getElementById("personal").classList.add("done");
            document.getElementById("payment").classList.add("done");
             document.getElementById("trata").classList.add("done");
            document.getElementById("exa").classList.add("done");
            document.getElementById("refe").classList.remove("done");
            document.getElementById("refe").classList.add("active");
            document.getElementById("info").classList.remove("done");
            document.getElementById("info").classList.remove("active");
        }

        if(n==6){
            document.getElementById("account").classList.add("done");
            document.getElementById("personal").classList.add("done");
            document.getElementById("payment").classList.add("done");
            document.getElementById("trata").classList.add("done");
            document.getElementById("exa").classList.add("done");
            document.getElementById("refe").classList.add("done");
            document.getElementById("info").classList.remove("done");
            document.getElementById("info").classList.add("active");
        }

         if(n==7){
            document.getElementById("account").classList.add("done");
            document.getElementById("personal").classList.add("done");
            document.getElementById("payment").classList.add("done");
            document.getElementById("trata").classList.add("done");
            document.getElementById("exa").classList.add("done");
            document.getElementById("refe").classList.add("done");
            document.getElementById("info").classList.add("done");
        }
    } 
    const showTab=(n)=>{
        var x = document.getElementsByTagName("fieldset");
        x[n].style.display = "block";
        console.log(n);
        ActiveTab(n);
       
    }
    const nextBtnFunction= (n) => {
        var x = document.getElementsByTagName("fieldset");
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        showTab(currentTab);
    }
    
    const nextbtn= document.querySelectorAll('.next')
    Array.from(nextbtn, (nbtn) => {
    nbtn.addEventListener('click',function()
    {
        nextBtnFunction(1);
    })
});

// previousbutton

const prebtn= document.querySelectorAll('.previous')
    Array.from(prebtn, (pbtn) => {
    pbtn.addEventListener('click',function()
    {
        nextBtnFunction(-1);
    })
});
    
})()