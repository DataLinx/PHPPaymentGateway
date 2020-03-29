<HTML>
<HEAD>
	<TITLE>Nastavitve transakcije - PHP:</TITLE>
</HEAD>   
<BODY bgcolor="#CCAACC" >


<form id="payment_form" method="POST" onsubmit="return selectedTransaction();">

    <div>
        <label for="TransactionType" style="color:green; font-size: 20px">Transaction type:</label><br>
        <select name="TranType" id="TranType" onchange="loadRadio()">
            <option value="debit" selected>Debit</option>
            <option value="preauth">Preauthorize</option>
            <option value="capture">Capture</option>
            <option value="void">Void</option>
            <option value="refund">Refund</option>
            <option value="status">Status</option>
        </select> 
        <br><br>
    </div>
    
    <div id="IntegrationTypeCheckbox" style="display: inline;">
        <label for="IntegrationType" style="color:green; font-size: 20px">Integration type:</label><br>
        <input type="radio" name="IntType" value="Redirect">Redirect to HPP<br>
        <input type="radio" name="IntType" value="paymentJS">Redirect to HPP entire iFrame<br>
        <input type="radio" name="IntType" value="paymentJS">paymentJS<br>
        <br>
    </div>
    
    <div id="withRegisterCheckbox" style="display: inline;">
        <label for="withReg" style="color:green; font-size: 20px">With register:</label><br>
        <select name="withRegister" id="withRegister" onchange="loadRadio()">
            <option value="true" >True</option>    
            <option value="false" selected>False</option>    
        </select> 
        <br><br>
    </div>
    
    
    <div id="CoF" style="display: inline;">
        <label  style="color:green; font-size: 20px">Use Card On File:</label><br>
        <select name="CardOnFile" id="CardOnFile" onchange="loadRadio()">
            <option value="true" >True</option>    
            <option value="false" selected>False</option>    
        </select> 
        <br><br>
    </div>    
    

    <div id="ReferenceTransactionId" style="display: none;">
        <label style="font-size: 16px">ReferenceTransactionId:</label><br>
        <input type="text" name="RefTranId" id="RefTranId" />
        <br><br>
    </div>    

    <div>
        <label>First name</label>
        <input type="text" id="first_name" name="first_name"  value='Janez'/>
    </div>
    <div>
        <label>Last name</label>
        <input type="text" id="last_name" name="last_name" value='Novak'/>
    </div>
    <div>
        <label >Email</label>
        <input type="text" id="email" name="email" />
    </div>
    <div>
        <input type="submit" value="Submit" />
</div>
</form>


<script type="text/javascript">
    function selectedTransaction(){
        var e = document.getElementById("TranType");
        var tranType = e.options[e.selectedIndex].value;
        if (tranType=="debit"){
            var radios = document.getElementsByName('IntType');
            for (var i = 0, length = radios.length; i < length; i++) {
                if (radios[0].checked) {
                   document.getElementById('payment_form').action = 'debit.php'; 
                   break;
                } else if(radios[1].checked) {
                    document.getElementById('payment_form').action = 'iframe.php'; 
                    break;
                } else if(radios[2].checked) {
                    document.getElementById('payment_form').action = 'javaScript.php'; 
                    break;
                } else {
                    alert("Select Integration Type");
                    return false;
                }
            }
        } else if (tranType=="preauth"){
            var radios = document.getElementsByName('IntType');
            for (var i = 0, length = radios.length; i < length; i++) {
                if (radios[0].checked) {
                   document.getElementById('payment_form').action = 'preauth.php'; 
                   break;
                } else if(radios[1].checked) {
                    document.getElementById('payment_form').action = 'iframe.php'; 
                    break;
                } else if(radios[2].checked) {
                    document.getElementById('payment_form').action = 'javaScript.php'; 
                    break;
                } else {
                    alert("Select Integration Type");
                    return false;
                }
            }
        } else if (tranType=="capture"){
            var value= document.getElementById('RefTranId').value.trim();
            switch(value){
                case "":
                    alert ("Enter ReferenceTransactionId");
                    return false;
                default:
                    document.getElementById('payment_form').action = 'capture.php';
                    break;
            }
        } else if (tranType=="void"){
            var value= document.getElementById('RefTranId').value.trim();
            switch(value){
                case "":
                    alert ("Enter ReferenceTransactionId");
                    return false;
                default:
                    document.getElementById('payment_form').action = 'void.php';
                    break;
            }
        } else if (tranType=="refund"){
            var value= document.getElementById('RefTranId').value.trim();
            switch(value){
                case "":
                    alert ("Enter ReferenceTransactionId");
                    return false;
                default:
                    document.getElementById('payment_form').action = 'refund.php';
                    break;
            }
        } else if (tranType=="status"){
            var value= document.getElementById('RefTranId').value.trim();
            switch(value){
                case "":
                    alert ("Enter ReferenceTransactionId");
                    return false;
                default:
                    document.getElementById('payment_form').action = 'status.php';
                    break;
            }
        } else {
            alert ("Please select Transaction Type");
            return false;
        }
    }


    function loadRadio(){

        var e = document.getElementById("TranType");
        var tranType = e.options[e.selectedIndex].value;
        document.getElementsByName("IntType")[2].disabled = false;
        if (tranType == "debit" || tranType == "preauth" ){
            document.getElementById( 'IntegrationTypeCheckbox' ).style.display = 'inline';
            document.getElementById( 'withRegisterCheckbox' ).style.display = 'inline';
            document.getElementById( 'CoF' ).style.display = 'inline';
            var f = document.getElementById("withRegister");
            var withRegister = f.options[f.selectedIndex].value;

            if (withRegister == 'true'){
                document.getElementById( 'ReferenceTransactionId' ).style.display = 'none';
                document.getElementById( 'CoF' ).style.display = 'none';
            } else{
                var d = document.getElementById("CardOnFile");
                var CoF = d.options[d.selectedIndex].value;
                if(CoF == 'true'){
                    document.getElementById( 'ReferenceTransactionId' ).style.display = 'inline';
                    document.getElementsByName("IntType")[2].disabled = true;
                    document.getElementsByName("IntType")[2].checked=false;

                } else{
                    document.getElementById( 'ReferenceTransactionId' ).style.display = 'none';
                }
            }
        } else {
            document.getElementById( 'IntegrationTypeCheckbox' ).style.display = 'none';
            document.getElementById( 'withRegisterCheckbox' ).style.display = 'none';
            document.getElementById( 'ReferenceTransactionId' ).style.display = 'inline';
            document.getElementById( 'CoF' ).style.display = 'none';
        }
    }

</script>

</BODY>
</HTML>