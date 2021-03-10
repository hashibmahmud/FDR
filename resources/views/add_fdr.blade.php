@extends('layout')
@section('title')
    FDR | Add FDR
@endsection
@section('content')
    <style>
        @media only screen and (max-width: 576px) {
            #create-btn {
                position: absolute;
                left: 0;
                right: 0;
                margin: auto;
            }
        }

    </style>
    <div style="height:50px;"></div>
    <div class="container">

        <h2 style="color:#4D9BE8;text-align:center;">Create New FDR</h2>

        <form class="form-horizontal" action="{{ url('/fdr-create') }}" method="POST" enctype="multipart/form-data"
            data-parsley-validate name="myform" onsubmit="return allOk()">
            {{ csrf_field() }}
            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="fdr_no"><b style="font-size: 15px;">FDR Number: <span
                            style="color:red;">*</span></b></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="fdr_no" id="fdr_no" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="bank_name"><b style="font-size: 15px;">Bank Name: <span
                            style="color:red;">*</span></b></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="bank_name" id="bank_name" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="branch_name"><b style="font-size: 15px;">Branch
                        Name: <span style="color:red;">*</span></b></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="branch_name" id="branch_name" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-2 col-md-3">
                    <label class="control-label" for="opening_amount"><b style="font-size: 15px;">Opening
                            Amount: <span style="color:red;">*</span></b></label><br>
                    <small>(In BDT Crore)</small>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="opening_amount" id="opening_amount" data-parsley-required
                        data-parsley-type="number" data-parsley-min="0">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="open_date"><b style="font-size: 15px;">Opening Date:
                        <span style="color:red;">*</span></b></label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="open_date" id="open_date" onchange="updateClosingDate()"
                        data-parsley-required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-2 col-md-3">
                    <label class="control-label " for="period"><b style="font-size: 15px;">Period: <span
                                style="color:red;">*</span></b></label><br>
                    <small>(In Months)</small>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="period" id="period" onkeyup="updateClosingDate()"
                        data-parsley-required data-parsley-type="integer">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="closing_date"><b style="font-size: 15px;">Next
                        Maturity:</b></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="closing_date" id="closing_date" readonly>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-2 col-md-3">
                    <label class="control-label" for="department_name"><b style="font-size: 15px;">Interesr
                            Rate: <span style="color:red;">*</span></b></label><br>
                    <small>(In percentage)</small>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="interest" id="department_name" data-parsley-required
                        data-parsley-min="0" data-parsley-max="100">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="contact_person"><b style="font-size: 15px;">Contact
                        Person: <span style="color:red;">*</span></b></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="contact_person" id="contact_person" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="contact_number"><b style="font-size: 15px;">Contact
                        Number: <span style="color:red;">*</span></b></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="contact_number" id="contact_number" required>
                </div>
            </div>
            {{-- <div class="form-group row">
                <label class="control-label col-sm-2" for="remark"><b style="font-size: 15px;">Remark: <span
                            style="color:red;">*</span></b></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="remark" id="remark">
                </div>
            </div> --}}

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="signatory"><b style="font-size: 15px;">Signatory: <span
                            style="color:red;">*</span></b></label>
                <div class="col-md-6" id="sig-container">
                    <input type="text" class="form-control mb-3" name="sig0" id="signatory">
                </div>
            </div>
            <div class="row d-flex justify-content-around">
                <p class="btn btn-primary" id="add_notif_field" onclick="addNotifField('sig-container', 'text', 5)">
                    +</p>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="fdr_inp"><b style="font-size: 15px;">FDR Instruments:
                        <span style="color:red;">*</span></b></label>
                <div class="col-md-6" id="file-container">
                    <input type="file" accept="application/pdf,.png, .jpg, .jpeg, .xls, .xlsx" class="form-control mb-3"
                        name="file0" id="fdr_inp">
                </div>
            </div>
            <div class="row d-flex justify-content-around">
                <p class="btn btn-primary" id="add_notif_field" onclick="addNotifField('file-container', 'file', 5)">+
                </p>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3"><b style="font-size: 15px">Notification <span
                            style="color:red;">*</span></b></label>
                <div class="col-md-6" id="notif-container">
                    <div class="row ml-0">
                        <input type="date" class="form-control mb-3 col-4" name="date0" />
                        <input type="time" class="form-control col-4" name="time0" />
                        <input type="text" placeholder="Recipient" class="form-control col-4" name="recipient0" />
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-around">
                <p class="btn btn-primary" id="add_notif_field" onclick="addNotifField('notif-container', 'date', 5)">+
                </p>
            </div>


            {{-- < class="form-group">
                <label class="control-label col-sm-2" for="info">Info:</label>
                <div class="col-sm-7">
                    <textarea class="form-control" name="info" id="info" rows="10"></textarea>
                </div>
            </> --}}


            <div class="form-group">
                <div class="col-sm-7">
                    {{-- <a href="{{ url('/notify') }}" class="btn btn-primary">Notify</a> --}}
                    <button type="submit" class="btn btn-outline-success" id="create-btn"
                        style="position: absolute; right: -20%;">Create</button>
                </div>
            </div>
            <div style="height: 100px;"></div>
        </form>


    </div>
    <script>
        async function allOk() {
            var elements = document.forms["myform"].elements;
            for (let i = 0; i < elements.length; i++) {
                if (!elements[i].value && elements[i].type != "submit") {
                    alert("Please fill all");
                    elements[i].focus();
                    return false;
                } else if (elements[i].name.startsWith("date")) {
                    var sigdate = new Date(elements[i].value);
                    var closedate = new Date(document.getElementById("closing_date").value);
                    if (Date.parse(sigdate) >= Date.parse(closedate)) {
                        alert("Notification date should be behind maturity date");
                        elements[i].focus();
                        return false;
                    }
                }
            }
            return true;
            /*let res = await swal({
                    title: "Are you sure?",
                    text: "You are going to add a new FDR!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willAdd) => {
                    if (wilAdd) {
                        console.log("Submit");
                        return false;
                    } else {
                        swal("FDR creation aborted").then((resp) => {
                            return false;
                        });
                    }
                });
            return res;*/
        }

        function updateClosingDate() {
            var valid_date = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31] // assuming each one is leap year
            var month_name = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var openingDate = document.getElementById('open_date');
            var period = document.getElementById('period');
            var closeDate = document.getElementById('closing_date');
            if (openingDate.value && period.value) {
                let open_date = new Date(openingDate.value);
                let newYear = 0,
                    newMonth = 0,
                    prd = parseInt(period.value),
                    newDate = open_date.getDate();
                let oldMonth = parseInt(open_date.getMonth()) + 1,
                    oldYear = parseInt(open_date.getFullYear());
                if (oldMonth + prd > 12) {
                    newYear = oldYear + Math.floor((oldMonth + prd) / 12);
                    newMonth = (oldMonth + prd) % 12;
                } else {
                    newYear = oldYear;
                    newMonth = oldMonth + prd;
                }
                if (valid_date[newMonth - 1] < open_date.getDate()) { // if date is not available in new month
                    newDate = valid_date[newMonth - 1];
                    if (newYear % 4 != 0 && newMonth == 2) { // in case of not leap year
                        newDate = 28;
                    }
                };
                closeDate.value = newDate + ' ' + month_name[newMonth - 1] + ' ' + newYear;
            } else {
                closeDate.value = "";
            }
        }

        function addNotifField(div_id, input_type, max_child) {
            var wrapper = document.getElementById(div_id);

            if (wrapper.children.length < max_child) {

                let div = document.createElement("div");
                div.classList.add("row", "ml-0");

                if (div_id == 'notif-container') {
                    let input = document.createElement("input");
                    input.classList.add("form-control", "col-4");
                    input.setAttribute("type", input_type);
                    input.setAttribute("name", "date" + wrapper.children.length);
                    div.appendChild(input);

                    input = document.createElement("input");
                    input.classList.add("form-control", "col-4");
                    input.setAttribute("type", 'time');
                    input.setAttribute("name", "time" + wrapper.children.length);
                    div.appendChild(input);

                    input = document.createElement("input");
                    input.classList.add("form-control", "col-3");
                    input.setAttribute("type", 'text');
                    input.setAttribute("placeholder", "Recipient");
                    input.setAttribute("name", "recipient" + wrapper.children.length);
                    div.appendChild(input);
                } else {
                    let input = document.createElement("input");
                    input.classList.add("form-control", "col-sm");
                    input.setAttribute("type", input_type);
                    if (input_type === "file") input.setAttribute("accept",
                        "application/pdf,.png, .jpg, .jpeg, .xls, .xlsx");
                    input.setAttribute("name", div_id.split("-")[0] + wrapper.children.length);
                    div.appendChild(input);
                }

                let crossbtn = document.createElement("p");
                crossbtn.classList.add("btn", "btn-outline-danger", "col-lg-1", "col-2");
                crossbtn.setAttribute("onclick", "deleteNotifField(this)");
                crossbtn.innerHTML = "<i class=\"fa-lg fas fa-minus-circle\"></i>";
                div.appendChild(crossbtn);

                wrapper.appendChild(div);
            } else {
                swal("You cannot add more then " + max_child + " input");
            }
        }

        function deleteNotifField(element) {
            if (element) element.parentNode.parentNode.removeChild(element.parentNode);
        }

    </script>

@endsection
