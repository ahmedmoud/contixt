<form class='resForm' >
    
<h3>احجزي موعدك في مراكز The Skin Avenue ، برجاء التسجيل</h3>

    <input type="text" required id="aName" placeholder="الإسم كاملاً" />
    <input type="text" required id="aPhone"  placeholder="رقم الموبايل" />
    <input type="text" required id="aDate" data-toggle="datepicker" autocomplete="off"   placeholder="يو م - الشهر - السنة" />
    <textarea id="aNote"  placeholder="ملاحظات أخرى" ></textarea>
    <div id="DivOutput" class="hideD" style=" height: 61px; overflow: hidden; "></div>
    <input type="submit" id="submitBTN" value="احجزي الآن" />

</form>
<style>
      
.resForm { position: relative;
    max-width: 500px;
    margin: auto;
    clear: both;
    overflow: hidden;
    background: url(https://w3n3u4x5.stackpathcdn.com/uploads/max_uploads/2018/09/1537276851.png);
    text-align: center;
    padding: 9px 37px 20px;
    border-top-left-radius: 35px;
    border-bottom-right-radius: 35px;
    border-top: 5px solid #4bd1c8;
    background-repeat: no-repeat;
    border-bottom: 5px solid #4bd1c8;
}
    
    form.resForm input,form.resForm textarea {
    text-align:  center;
    min-height:  43px;
    margin:  3px;
    width:  100%;
    border:  0;
    border-radius: 4px;
    background-color: #ffffffdb;
    color: #000;
}

form.resForm textarea {
    min-height:  130px;
    resize: none;
    padding:9px;
}

form.resForm input::placeholder, form.resForm textarea::placeholder {
    color: #000000a1;
}

form.resForm input[type="submit"] {
    background: #00c5b5ab;
    color:  #fff;
    font-size: 18px;
    border: 2px solid #ffffffe0;
    padding: 10px;
}

form.resForm input:focus , form.resForm textarea:focus { 
    background: #00c5b5ab;
    color: #fff;
    border-bottom: 2px solid #82593ea3;
}

form.resForm h3{
    background: #ec106e6e;
    padding: 11px;
    color: #fff;
    border-radius: 8px;
}
 #DivOutput img {
    margin-top: -41px;
    height: 128px;
    width: 150px;
    max-height: 500px !important;
}

.hideD {
    display:none;
}

</style>

