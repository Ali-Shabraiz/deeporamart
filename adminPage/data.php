<?php
     session_start();
     if(!isset($_SESSION['user'])){
     header('Location: ./index.html');
        

     }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./CSS/datatable.css">
</head>
<body>
    <form  enctype="multipart/form-data" id="addItemForm">
        <h2><span id="formtext">Add</span> Item</h2>
        <input type="text" name="name" placeholder="Enter Item Name" required>
        <input type="number" name="op" placeholder="buy Price" required>
        <input type="number" name="sp" placeholder="Sale Price" required>
        <input name="itemImage" accept="image/*" type="file" required>
        <input type="hidden" name="j" id="editItemId" value="">
        <button type="submit">Add</button>
    </form>
    <table id="itemsTable">
        <tr>
            <th>Product</th>
            <th>Sell</th>
            <th>Stock</th>
            <th>Options</th>
        </tr>
        
    </table>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var formtext = document.getElementById("formtext");
        var isEditing = false;
        var itemsTable = document.getElementById('itemsTable');
        var addForm = document.querySelector('#addItemForm');
        var editItemId = document.getElementById('editItemId');
        var inputsOfaddform= document.querySelectorAll("#addItemForm input");
        let formData;
        addForm.addEventListener('submit',e=>{
            e.preventDefault();
         formData = new FormData(addForm);

        if(editItemId.value == '')
            adddata();
        else{
            editdata(editItemId.value);
        }
            
        });
        function adddata(){
            $.ajax({
                url: './PHP/addData.php',
                method: 'POST',
                data: formData,
                processData: false, // Important for file upload
                contentType: false, // Important for file upload
                success: (data) => {
                    inputsOfaddform[0].value = '';
                    inputsOfaddform[1].value = '';
                    inputsOfaddform[2].value = '';
                    fetch_items();
                }
            });
        }
        function activeEdit(id){
            if(!isEditing){
                editItemId.value = id;
                formtext.innerHTML = 'edit';
                isEditing = true;
            }
            else{
                editItemId.value = '';
                formtext.innerHTML = 'Add';
                isEditing = false;
            }
            
        }
        function editdata(id){
            $.ajax({
                url: './PHP/editData.php',
                method: 'POST',
                data: formData,
                processData: false, // Important for file upload
                contentType: false, // Important for file upload
                success: (data) => {
                    inputsOfaddform[0].value = '';
                    inputsOfaddform[1].value = '';
                    inputsOfaddform[2].value = '';
                    editItemId.value = '';
                    fetch_items();
                }
            });
        }

        function fetch_items(){
            fetch('./PHP/fetch_all_items.php').then(res => {
                return res.json();
            }).then(data => {
                  itemsTable.innerHTML = ` <tr>
            <th>Product</th>
            <th>Sell</th>
            <th>Stock</th>
            <th>Options</th>
        </tr>`;
                displayData(data);
            })
        }
        fetch_items()
        function displayData(data){
            console.log(data);
            
            data.forEach(item => {
                var tr = document.createElement('tr');
                tr.innerHTML = `
            <td class="item"><img src="../assets/img/${item.imgPath}" alt=""><div class="content"><span class="name">${item.Name}</span><span class="op">${item.op}</span></div></td>
            <td>${item.sp}</td>
            <td><div class="stockNumber"><button style="--clr: red;" onclick="updateQuantity(${item.ID},this.value,'-')" id="minus${item.ID}">-</button><span id="stockNumber${item.ID}">${item.quantity}</span><button onclick="updateQuantity(${item.ID},this.value,'+')" id="plus${item.ID}" value="${item.quantity}" style="--clr:green;">+</button></div></td>
            <td><div class="options"><button style="--clr:green;" class="fas fa-edit" onclick="activeEdit(${item.ID})"></button><button style="--clr:red;" class="fa fa-trash" onclick="deletedata(${item.ID})"></button></div></td>
                `;
                itemsTable.appendChild(tr);
            });
        }
        function updateQuantity(i,value,sign){
            var val = eval(`${value}${sign}1`);
                document.getElementById(`plus${i}`).value = val;
                document.getElementById(`minus${i}`).value = val;
                document.getElementById(`stockNumber${i}`).textContent = val;

             $.ajax({
                url: './PHP/changeStockNum.php',
                method: 'POST',
                data: {id:i,quan:val},
                success: (data) => {
                  
                    // fetch_items();
                }
            });
        }
        function deletedata(i){
            $.ajax({
                url: './PHP/deleteData.php',
                method: 'POST',
                data: {id:i},
                success: (data) => {
                    fetch_items();
                }
            });
        }
    </script>
</body>
</html>