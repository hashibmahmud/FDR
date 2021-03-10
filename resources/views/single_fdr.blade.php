@extends('layout')
@section('title')
    FDR | Details
@endsection
@section('content')
    <div class="container">
        <div class="mb-4"></div>
        <form class="form-horizontal" action="{{ url('/fdr-edit') }}" method="POST" enctype="multipart/form-data"
            data-parsley-validate name="myform">
            {{ csrf_field() }}
            <input type="hidden" id="id" name="fdr_id" value="{{ $fdr['id'] }}">
            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="fdr_no"><b style="font-size: 15px;">FDR Number: <span
                            style="color:red;">*</span></b></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="fdr_no" id="fdr_no" value="{{ $fdr['fdr_number'] }}"
                        readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="bank_name"><b style="font-size: 15px;">Bank Name: <span
                            style="color:red;">*</span></b></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="bank_name" id="bank_name"
                        value="{{ $fdr['bank_name'] }}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="branch_name"><b style="font-size: 15px;">Branch
                        Name: <span style="color:red;">*</span></b></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="branch_name" id="branch_name"
                        value="{{ $fdr['branch_name'] }}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-2 col-md-3">
                    <label class="control-label" for="opening_amount"><b style="font-size: 15px;">Opening
                            Amount: <span style="color:red;">*</span></b></label><br>
                    <small>(In BDT Crore)</small>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="opening_amount" id="opening_amount"
                        value="{{ $fdr['opening_amount'] }}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="open_date"><b style="font-size: 15px;">Opening Date:
                        <span style="color:red;">*</span></b></label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="open_date" id="open_date" onchange="updateClosingDate()"
                        data-parsley-required readonly value="{{ $fdr['opening_date'] }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-2 col-md-3">
                    <label class="control-label" for="period"><b style="font-size: 15px;">Period: <span
                                style="color:red;">*</span></b></label><br>
                    <small>(In months)</small>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="period" id="period" onkeyup="updateClosingDate()"
                        data-parsley-required data-parsley-type="integer" readonly value="{{ $fdr['period'] }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="closing_date"><b style="font-size: 15px;">Next
                        Maturity:</b></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="closing_date" id="closing_date"
                        value="{{ $fdr['next_maturity'] }}" readonly>
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
                        data-parsley-min="0" data-parsley-max="100" value="{{ $fdr['interest'] }}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="contact_person"><b style="font-size: 15px;">Contact
                        Person: <span style="color:red;">*</span></b></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="contact_person" id="contact_person"
                        value="{{ $fdr['contact_person'] }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="contact_number"><b style="font-size: 15px;">Contact
                        Number: <span style="color:red;">*</span></b></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="contact_number" id="contact_number"
                        value="{{ $fdr['contact_number'] }}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="signatory"><b style="font-size: 15px;">Signatory: <span
                            style="color:red;">*</span></b></label>
                <div class="col-md-6" id="sig-container">
                    @foreach ($sigs as $item)
                        <div class="row ml-0">
                            <input type="text" class="form-control col-sm" name="sig{{ $loop->index }}"
                                value="{{ $item['signatory'] }}" readonly>
                            <p class="btn btn-outline-danger col-lg-1 col-2 pa-2" onclick="deleteNotifField(this)"><i
                                    class="fa-lg fas fa-minus-circle"></i>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row d-flex justify-content-around">
                <p class="btn btn-outline-primary" id="add_notif_field" onclick="addNotifField('sig-container', 'text', 5)">
                    Add field</p>
            </div>
            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3" for="fdr_inp"><b style="font-size: 15px;">FDR Instruments:
                        <span style="color:red;">*</span></b></label>
                <div class="col-md-6" id="file-container">
                    @foreach ($instruments as $item)
                        <div class="row ml-0">
                            <input type="text" class="form-control col-sm"
                                name="file{{ $loop->index }}-{{ $item['id'] }}"
                                value="{{ $item['old_file_name'] }}" readonly>
                            <a href="{{ URL::to('/') . '\uploads\\' . $item->new_file_name }}"
                                class="btn btn-outline-primary col-2 mb-3" target="_blank">View</a>
                            <div style="width: 20px;"></div>
                            <p class="btn btn-outline-danger col-lg-1 col-2" onclick="deleteNotifField(this)"><i
                                    class="fa-lg fas fa-minus-circle"></i></p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row d-flex justify-content-around">
                <p class="btn btn-outline-primary" id="add_notif_field"
                    onclick="addNotifField('file-container', 'file', 5)">Add field
                </p>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2 col-md-3"><b style="font-size: 15px">Notification <span
                            style="color:red;">*</span></b></label>
                <div class="col-md-6" id="notif-container">
                    @foreach ($notifications as $item)
                        <div class="row ml-0">
                            <input type="text" class="form-control col-4" name="date{{ $loop->index }}"
                                value="{{ $item['date'] }}" readonly>
                            <input type="text" class="form-control col-4" name="time{{ $loop->index }}"
                                value="{{ $item['time'] }}" readonly>
                            <input type="text" class="form-control col-3" name="recipient{{ $loop->index }}"
                                value="{{ $item['recipient'] }}" readonly>
                            <p class="btn btn-outline-danger col-lg-1 col-2" onclick="deleteNotifField(this)"><i
                                    class="fa-lg fas fa-minus-circle"></i></p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row d-flex justify-content-around">
                <p class="btn btn-outline-primary" id="add_notif_field"
                    onclick="addNotifField('notif-container', 'date', 5)">Add field
                </p>
            </div>

            <div class="row my-5">
                <div class="col-sm-2"></div>
                <div class="col-sm-6 d-flex justify-content-around align-items-center">
                    <a href="#" id="editbtn" class="btn btn-outline-primary">Edit</a>
                    {{-- <a href="#" id="dltbtn" class="btn btn-outline-danger">Delete</a> --}}
                    <a href="{{ url('/fdr-renew/'.$fdr['id'].'') }}" target="_blank" id="renewbtn" class="btn btn-outline-success">Renew</a>
                    @if(app('request')->input('action') == 'verify')
                        <a href="{{ route('verify', $fdr['id']) }}" class="btn btn-outline-primary">Verify</a>
                        <a href="" class="btn btn-outline-danger">Reject</a>
                    @endif
                </div>
            </div>

            <div style="height: 100px;"></div>
        </form>
    </div>
    <script>
        var mode = "view";
        document.getElementById("renewbtn").addEventListener("click", (e) => {
            e.preventDefault();
            var val = document.getElementById("closing_date").value;
            if(Date.parse(val) > Date.parse(new Date())) {
                swal("Renew starts from " + val);
            } else {
                window.open('/fdr-renew/' + document.getElementById("id").value);
            }
        });

        /*document.getElementById("dltbtn").addEventListener("click", (event) => {
            event.preventDefault();
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this FDR!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        fetch('/api/fdr/{{ $fdr->id }}', {
                            method: 'DELETE',
                        }).then((resp => {
                            if (resp.ok == false) {
                                swal(JSON.stringify(resp));
                                return resp;
                            }
                            swal("Your FDR has been deleted!", {
                                icon: "success",
                            }).then((resp) => {
                                window.location.href = "{{ route('allfdr') }}";
                            });
                        })).catch((e) => {
                            swal(JSON.stringify(e));
                        });
                    } else {
                        swal("Your FDR is safe!");
                    }
                });
        });*/

        document.getElementById("editbtn").addEventListener("click", (e) => {
            e.preventDefault();
            if (mode == "view") {
                mode = "edit";
                document.getElementById("editbtn").innerText = "Submit";

                /*var element = document.getElementById("dltbtn");
                element.parentNode.removeChild(element);*/

                var element = document.getElementById("renewbtn");
                element.parentNode.removeChild(element);

                var elements = document.forms["myform"].elements;
                for (let i = 0; i < elements.length; i++) {
                    if (elements[i].name !== "closing_date")
                        elements[i].removeAttribute("readonly");
                    if (elements[i].name.startsWith("file")) {
                        elements[i].setAttribute("readonly", "");
                    }
                }
            } else {
                let elements = document.forms["myform"].elements;
                let sigflag = 0,
                    notifflag = 0,
                    fileflag = 0;
                for (let i = 0; i < elements.length; i++) {
                    if (!elements[i].value && elements[i].type != "submit") {
                        swal("Please fill all");
                        elements[i].focus();
                        return;
                    } else if (elements[i].name.startsWith("date")) {
                        var sigdate = new Date(elements[i].value);
                        var closedate = new Date(document.getElementById("closing_date").value);
                        if (Date.parse(sigdate) >= Date.parse(closedate)) {
                            swal("Notification date should be behind maturity date");
                            elements[i].focus();
                            return;
                        }
                    } else if (elements[i].name.startsWith("sig")) sigflag = 1;
                    else if (elements[i].name.startsWith("file")) fileflag = 1;
                    else if (elements[i].name.startsWith("date")) notifflag = 1;
                }
                if (sigflag === 0) {
                    swal("At least one signatory is required");
                    return;
                }
                if (fileflag === 0) {
                    swal("At least one file is required");
                    return;
                }
                if (notifflag === 0) {
                    swal("At least one notification is required");
                    return;
                }
                document.forms["myform"].submit();
            }
        });

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
            if (mode == "view") {
                return;
            }
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
            if (mode == "view") return;
            if (element) {
                let container = element.parentNode.parentNode;
                let containerId = container.id.split("-")[0];
                container.removeChild(element.parentNode);
                let children = container.children;
                if (children.length === 0) return;
                if (containerId === "notif") {
                    children[0].children[0].setAttribute("name", "date0");
                    children[0].children[1].setAttribute("name", "time0");
                    children[0].children[2].setAttribute("name", "recipient0");
                } else if (containerId === "file") {
                    let name = children[0].getElementsByTagName("input")[0].name;
                    if (name.includes("-"))
                        children[0].getElementsByTagName("input")[0].setAttribute("name", containerId + "0" + "-" + name
                            .split(
                                "-")[1]);
                    else children[0].getElementsByTagName("input")[0].setAttribute("name", containerId + "0");
                } else {
                    children[0].getElementsByTagName("input")[0].setAttribute("name", containerId + "0");
                }
                for (let i = 1; i < children.length; i++) {
                    if (containerId === "notif") {
                        children[i].getElementsByTagName("input")[0].setAttribute("name", "date" + i);
                        children[i].getElementsByTagName("input")[1].setAttribute("name", "time" + i);
                        children[i].getElementsByTagName("input")[2].setAttribute("name", "recipient" + i);
                    } else if (containerId === "file") {
                        let name = children[i].getElementsByTagName("input")[0].name;
                        if (name.includes("-"))
                            children[i].getElementsByTagName("input")[0].setAttribute("name", containerId + i + "-" + name
                                .split("-")[1]);
                        else children[i].getElementsByTagName("input")[0].setAttribute("name", containerId + i);
                    } else {
                        children[i].getElementsByTagName("input")[0].setAttribute("name", containerId + i);
                    }
                }
            }
        }

    </script>
@endsection
