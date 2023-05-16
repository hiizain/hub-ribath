@extends('../../layouts/app')

@section('container')
<div class="my-5 mx-4">
    <h2>{{ $program->nama_program.' '.$program->tahun }}</h2>
    <hr>
    <form id="editProgram">
        <div class="form-group mb-3">
            {{-- <textarea class="form-control" name="nama_program" id="nama_program">{{ $program->deskripsi }}</textarea> --}}
            <div class="row">
                <div class="col-10">
                    <h5>Nama Program</h5>
                    <input class="form-control" type="text" name="nama_program" id="nama_program" value="{{ $program->nama_program }}">
                </div>
                <div class="col-2">
                    <h5>Tahun</h5>
                    <select class="form-control select2" name="tahun" id="">
                        <?php $tahun = date('Y'); ?>
                        @for($i=$tahun; $i>$tahun-5; $i--)
                            @if($i == $program->tahun)
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else 
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <h5>Deskripsi</h5>
            <textarea class="form-control" name="deskripsi" id="deskirpsi">{{ $program->deskripsi }}</textarea>
            {{-- <input class="form-control" type="text" value="{{ $program->deskripsi }}"> --}}
        </div>
        <div class="form-group mb-3">
            <h5>Kegiatan</h5>
            <div class="card">
                <div class="row card-body" id="listKegiatan">
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <h5>Tahapan</h5>
            <div class="row mb-3">
                <div class="row d-flex flex-row">
                    <div class="col-6">
                        {{-- <textarea class="form-control" name="" id="">Tahap</textarea> --}}
                        <div class="card">
                            <div class="row card-body">
                                <p class="mx-2 my-0 p-0">@if($tahap !== null){{ $tahap->tahap->nama_tahap }}@else Tidak ada rentang tahap yang berjalan saat ini @endif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <p>Pilih tahapan yang diperlukan dibawah ini</p>
            </div>
            <div class="row">
                <div class="form-group">
                    <input type="hidden" name="tahap" id="dataTahap">
                    <label for="tahap_id" class="col-form-label">Tahap :</label>
                    <select multiple="multiple" class="form-control select2 multiple" id="tahap_id">
                    {{-- <select multiple="multiple" class="form-control select2 multiple" name="tahap[]" id="tahap_id"> --}}
                        <option value="" hidden>Pilih Tahap</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3 p-2" id="listTahap"></div>
        </div>
        <div class="form-group d-flex justify-content-end mb-3">
            <a class="btn btn-danger" href="{{ route('back.program.index') }}">Batal</a>
            <button class="btn btn-success ms-2" type="submit">Simpan</button>
        </div>
    </form>
</div>

<script>
    const site_url = '{{ url('') }}';
    const program = '<?php echo json_encode($program) ?>';
    const referensi = JSON.parse(program);
    const idTahap = [];
    let dataTahap = [];
    let refTahapProgram = [];
    let refTahapId = [];
    // let refTahapProgram = [];
    $(document).ready(function () {
        let refKegiatanProgram = [];
        $.getJSON(
            `${site_url}/api/kegiatan-program/by_program/${referensi.id}`,
            null,
            function (data, textStatus, jqXHR) {
                if (data != null) {
                    if (data.data != null) {
                        data.data.forEach((element) => {
                            refKegiatanProgram.push(element.kegiatan_id); 
                        });
                    }
                }
            });
        $.getJSON(
            `${site_url}/api/kegiatan`,
            null,
            function (data, textStatus, jqXHR) {
                if (data != null) {
                    if (data.data != null) {
                        count = data.data.length;
                        checklist = `<div class="col-6">`;
                        for(i=0; i<Math.ceil(count/2); i++){
                            checklist += `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check`+data.data[i].id+`" name="kegiatan[]" value="`+data.data[i].id+`" `+(refKegiatanProgram.includes(data.data[i].id) ? 'checked' : '')+`>
                                <label class="form-check-label" for="check`+data.data[i].id+`">`+data.data[i].nama_kegiatan+`</label>
                            </div>
                            `
                        }
                        checklist += `</div><div class="col-6">`
                        for(i=Math.ceil(count/2); i<count; i++){
                            checklist += `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check`+data.data[i].id+`" name="kegiatan[]" value="`+data.data[i].id+`" `+(refKegiatanProgram.includes(data.data[i].id) ? 'checked' : '')+`>
                                <label class="form-check-label" for="check`+data.data[i].id+`">`+data.data[i].nama_kegiatan+`</label>
                            </div>
                            `
                        }
                        checklist += `</div>`
                        $('#listKegiatan').html(checklist);
                    }
                }
            });

        // $.getJSON(
        //     `${site_url}/api/tahap`,
        //     null,
        //     function (data, textStatus, jqXHR) {
        //         if (data != null) {
        //             data.data.forEach((element) => {
        //                 $('#tahap_id').append(`<option value="${element.id}/${element.nama_tahap}"`+(refKegiatan.includes(element.id) ? 'selected' : '')+`>${element.nama_tahap}</option>`);
        //             });
        //         }
        //     });

        // let refTahapProgram = [];
        // let refTahapId = [];
        $.getJSON(
            `${site_url}/api/tahap-program/by_program/${referensi.id}`,
            null,
            function (data, textStatus, jqXHR) {
                tahap = `<div class="card">
                            <div class="row card-body">
                                <hr>`;
                if (data != null) {
                    if (data.data != null) {
                        data.data.forEach((element) => {
                            refTahapId.push(element.tahap_id);
                            refTahapProgram.push({ tahap_id: element.tahap_id, mulai: element.mulai, selesai: element.selesai});
                            tahap += `
                            <div class="row mb-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            `+element.nama_tahap+`
                                        </div>
                                        <div class="col-6">
                                            <input class="form-control" id="date-tahap-`+element.tahap_id+`" type="text"">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            `;
                        });
                    }
                }
                tahap += `
                    </div>
                </div>
                `;
                $('#listTahap').html(tahap);
                refTahapProgram.forEach((element) => {
                    dataTahap.push({ tahap_id: element.tahap_id, mulai: element.mulai, selesai: element.selesai});
                    // idTahap.push(element.tahap_id);
                    // console.log(element.mulai)
                    $('#date-tahap-'+element.tahap_id).daterangepicker({
                        timePicker: true,
                        timePicker24Hour: true,
                        autoApply: true,
                        startDate: new Date(element.mulai),
                        endDate: new Date(element.selesai),
                        locale: {
                            format: 'D MMM YYYY (H:mm)'
                        }
                    });
                    // $('#date-tahap-'+element.tahap_id).on('apply.daterangepicker', function(ev, picker) {
                    //         let index;
                    //         dataTahap.forEach((item) => {
                    //             if(item.tahap_id == element.tahap_id){
                    //                 index = dataTahap.indexOf(item)
                    //             }
                    //         });
                    //         console.log(index);
                    //         dataTahap[index] = {tahap_id:element, mulai:picker.startDate.format('YYYY-MM-DD HH:MM:ss'), selesai:picker.endDate.format('YYYY-MM-DD HH:MM:ss')};
                    //         // console.log(dataTahap);
                    //         $('#dataTahap').val(JSON.stringify(dataTahap));
                    //     });
                    $('#date-tahap-'+element.tahap_id).on('apply.daterangepicker', function(ev, picker) {
                        
                        let index;
                        dataTahap.forEach((item) => {
                            if(item.tahap_id == element.tahap_id){
                                index = dataTahap.indexOf(item)
                            }
                        });
                        dataTahap[index] = {tahap_id:element.tahap_id, mulai:picker.startDate.format('YYYY-MM-DD HH:MM:ss'), selesai:picker.endDate.format('YYYY-MM-DD HH:MM:ss')};
                        console.log(dataTahap);
                        $('#dataTahap').val(JSON.stringify(dataTahap));
                    });
                })
                $('#dataTahap').val(JSON.stringify(dataTahap));
            });

        $.getJSON(
            `${site_url}/api/tahap`,
            null,
            function (data, textStatus, jqXHR) {
                if (data != null) {
                    data.data.forEach((element) => {
                        $('#tahap_id').append(`<option value="${element.id}/${element.nama_tahap}"`+(refTahapId.includes(element.id) ? 'selected' : '')+`>${element.nama_tahap}</option>`);
                    });
                }
            });
         
        // let refTahapProgram = [];
        // $.getJSON(
        //     `${site_url}/api/tahap-program/by_program/${referensi.id}`,
        //     null,
        //     function (data, textStatus, jqXHR) {
        //         tahap = ``;
        //         count = 0;
        //         if (data != null) {
        //             if (data.data != null) {
        //                 data.data.forEach((element) => {
        //                     refTahapProgram.push({ tahap_id: element.tahap_id, mulai: element.mulai, selesai: element.selesai});
        //                     tahap += `
        //                     <div class="row mb-3">
        //                         <div class="form-group">
        //                             <div class="row">
        //                                 <div class="col-6">
        //                                     `+element.nama_tahap+`
        //                                 </div>
        //                                 <div class="col-6">
        //                                     <input type="hidden" name="id_tahap[`+count+`]" value="`+element.tahap_id+`">
        //                                     <input class="form-control" id="date-tahap-`+element.tahap_id+`" type="text" name="date_tahap[`+count+`]">
        //                                 </div>
        //                             </div>
        //                         </div>
        //                     </div>
        //                     `;
        //                     count++;
        //                 });
        //             }
        //         }
        //         $('#listTahap').html(tahap);
        //         refTahapProgram.forEach((element) => {
        //             // idTahap.push(element.tahap_id);
        //             $('#date-tahap-'+element.tahap_id).daterangepicker({
        //                 timePicker: true,
        //                 timePicker24Hour: true,
        //                 autoApply: true,
        //                 startDate: new Date(element.mulai),
        //                 endDate: new Date(element.selesai),
        //                 locale: {
        //                     format: 'D MMM YY (H:mm)'
        //                 }
        //             });
        //             $('#date-tahap-'+element.tahap_id).on('apply.daterangepicker', function(ev, picker) {
        //                 updateDate(element.tahap_id,picker.startDate.format('YYYY-MM-DD HH:MM:ss'),picker.endDate.format('YYYY-MM-DD HH:MM:ss'))
        //             });
        //         })
        //     });

    //     $('#detailProgram').submit(function (e) {
    //         e.preventDefault();
    //         Swal.fire({
    //             icon: "question",
    //             title: "Peringatan",
    //             text: "Apakah Anda yakin ingin mengubah data program?",
    //             showCancelButton: true,
    //             cancelButtonText: "Batal",
    //             confirmButtonText: "Simpan",
    //             confirmButtonColor: "#008080",
    //             reverseButtons: true,
    //         }).then((result) => {
    //             if (result.value) {
    //                 $.ajax({
    //                     type: 'ajax',
    //                     method: 'POST',
    //                     headers: {
    //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                     },
    //                     url: `${site_url}/back/program/${referensi.id}`,
    //                     // data: $('#detailProgram').serialize(),
    //                     data: new FormData($('#detailProgram')[0]),
    //                     contentType: false,
    //                     processData: false,
    //                     dataType: 'json',
    //                     // beforeSend: function () { },
    //                     success: function (response) {
    //                         // console.log(response);
    //                         if ((response.status === 'error')) {
    //                             Swal.fire('Gagal!', 'Aplikasi gagal terhubung dengan server. Silahkan hubungi admin.', 'error');
    //                         }
    //                         if (response.status == 'success') {
    //                             Swal.fire('Update Berhasil!', response.message, 'success').then(function () {
    //                                 location.href = site_url+'/program';
    //                             })
    //                         }
    //                     },
    //                     error: function (xmlhttprequest, textstatus, message) {
    //                         // text status value : abort, error, parseerror, timeout
    //                         // default xmlhttprequest = xmlhttprequest.responseJSON.message

    //                         Swal.fire('Gagal!', xmlhttprequest.responseJSON.message, 'error');
    //                         // console.log(xmlhttprequest.responseJSON);
    //                     },
    //                 });
    //             }
    //         });
    //     });

    //     // $('#form-tahap').submit(function (e) {
    //     //     e.preventDefault();
    //     //     Swal.fire({
    //     //         icon: "question",
    //     //         title: "Peringatan",
    //     //         text: "Apakah Anda yakin ingin mengubah data tahap program?",
    //     //         showCancelButton: true,
    //     //         cancelButtonText: "Batal",
    //     //         confirmButtonText: "Simpan",
    //     //         confirmButtonColor: "#008080",
    //     //         reverseButtons: true,
    //     //     }).then((result) => {
    //     //         if (result.value) {
    //     //             $.ajax({
    //     //                 type: 'ajax',
    //     //                 method: 'POST',
    //     //                 headers: {
    //     //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     //                 },
    //     //                 url: `${site_url}/program/date-tahap-program/${referensi.id}`,
    //     //                 // data: $('#detailProgram').serialize(),
    //     //                 // data: {
    //     //                 //     id : idTahap,
    //     //                 //     data : new FormData($('#form-tahap')[0]),
    //     //                 // },
    //     //                 data : new FormData($('#form-tahap')[0]),
    //     //                 contentType: false,
    //     //                 processData: false,
    //     //                 dataType: 'json',
    //     //                 // beforeSend: function () { },
    //     //                 success: function (response) {
    //     //                     console.log(response);
    //     //                     // if ((response.status === 'error')) {
    //     //                     //     Swal.fire('Gagal!', 'Aplikasi gagal terhubung dengan server. Silahkan hubungi admin.', 'error');
    //     //                     // }
    //     //                     // if (response.status == 'success') {
    //     //                     //     Swal.fire('Pendataan Berhasil!', response.message, 'success').then(function () {
    //     //                     //         location.href = site_url+'/program';
    //     //                     //     })
    //     //                     // }
    //     //                 },
    //     //                 error: function (xmlhttprequest, textstatus, message) {
    //     //                     // text status value : abort, error, parseerror, timeout
    //     //                     // default xmlhttprequest = xmlhttprequest.responseJSON.message

    //     //                     Swal.fire('Gagal!', xmlhttprequest.responseJSON.message, 'error');
    //     //                     // console.log(xmlhttprequest.responseJSON);
    //     //                 },
    //     //             });
    //     //         }
    //     //     });
    //     // });
    // console.log(dataTahap);
    // console.log(refTahapId);
    });

    $('#tahap_id').change(function (e) { 
        e.preventDefault();
        val = $(this).val();
        count = 0;
        tahap = `<div class="card">
                    <div class="row card-body">
                        <hr>`;
        refTahapId = [];
        val.forEach((element) => {
            arrVal = element.split('/');
            id = arrVal[0];
            nama = arrVal[1];
            refTahapId.push(parseInt(id));
            // refTahapId.push(id);
            tahap += `
                <div class="row mb-3">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                `+nama+`
                            </div>
                            <div class="col-6">
                                <input class="form-control" id="date-tahap-`+id+`" type="text"">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            `;
            count++;
        });
        tahap += `
            </div>
        </div>
        `;
        $('#listTahap').html(tahap);
        // if(dataTahap.length > 0){
            if(dataTahap.length > refTahapId.length){
                dataTahap.forEach((item) => {
                    cek = refTahapId.map(el => el).indexOf(item.tahap_id);
                    if(cek == -1){
                        cekVal = item.tahap_id;
                        index = dataTahap.map(el => el.tahap_id).indexOf(cekVal);
                        dataTahap.splice(index, 1);
                    }
                });
            } 
            refTahapId.forEach((element) => {
                if(dataTahap.length > 0){
                    dataTahap.forEach((item) => {
                        // console.log(dataTahap);
                        // console.log("id"+element);
                        // console.log(dataTahap);
                        index = dataTahap.map(el => el.tahap_id).indexOf(parseInt(element));
                        // console.log(typeof index);
                        // cek.push(index);
                        // console.log(cek);
                        if(index == -1){
                            // console.log("index -1");
                            $('#date-tahap-'+element).daterangepicker({
                                timePicker: true,
                                timePicker24Hour: true,
                                autoApply: true,
                                startDate: moment().startOf('hour'),
                                endDate: moment().startOf('hour').add(24, 'hour'),
                                locale: {
                                    format: 'D MMM YYYY (H:mm)'
                                },
                            });
                            dataTahap.push({tahap_id:element, mulai:moment().startOf('hour').format('YYYY-MM-DD HH:MM:ss'), selesai:moment().startOf('hour').add(24, 'hour').format('YYYY-MM-DD HH:MM:ss')});
                        } else {
                            // console.log("index bukan -1");
                            if(item.tahap_id == element){
                                $('#date-tahap-'+element).daterangepicker({
                                    timePicker: true,
                                    timePicker24Hour: true,
                                    autoApply: true,
                                    startDate: new Date(item.mulai),
                                    endDate: new Date(item.selesai),
                                    locale: {
                                        format: 'D MMM YYYY (H:mm)'
                                    },
                                });
                                dataTahap[index] = {tahap_id:item.tahap_id, mulai:item.mulai, selesai:item.selesai};
                            } 
                        }
                    });
                } else {
                    $('#date-tahap-'+element).daterangepicker({
                        timePicker: true,
                        timePicker24Hour: true,
                        autoApply: true,
                        startDate: moment().startOf('hour'),
                        endDate: moment().startOf('hour').add(24, 'hour'),
                        locale: {
                            format: 'D MMM YYYY (H:mm)'
                        },
                    });
                    dataTahap.push({tahap_id:element, mulai:moment().startOf('hour').format('YYYY-MM-DD HH:MM:ss'), selesai:moment().startOf('hour').add(24, 'hour').format('YYYY-MM-DD HH:MM:ss')});
                }
                $('#date-tahap-'+element).on('apply.daterangepicker', function(ev, picker) {
                    let index;
                    dataTahap.forEach((item) => {
                        if(item.tahap_id == element){
                            index = dataTahap.indexOf(item)
                        }
                    });
                    dataTahap[index] = {tahap_id:element, mulai:picker.startDate.format('YYYY-MM-DD HH:MM:ss'), selesai:picker.endDate.format('YYYY-MM-DD HH:MM:ss')};
                    $('#dataTahap').val(JSON.stringify(dataTahap));
                });
            })
            $('#dataTahap').val(JSON.stringify(dataTahap));
            // }
        // } else {
        //     refTahapId.forEach((element) => {
        //         $('#date-tahap-'+element).daterangepicker({
        //             timePicker: true,
        //             timePicker24Hour: true,
        //             autoApply: true,
        //             startDate: moment().startOf('hour'),
        //             endDate: moment().startOf('hour').add(24, 'hour'),
        //             locale: {
        //                 format: 'D MMM YYYY (H:mm)'
        //             },
        //         });
        //         dataTahap.push({tahap_id:element, mulai:moment().startOf('hour').format('YYYY-MM-DD HH:MM:ss'), selesai:moment().startOf('hour').add(24, 'hour').format('YYYY-MM-DD HH:MM:ss')});
        //     });
        // }
        // console.log(refTahapId);
        // console.log(dataTahap);
        // $('#dataTahap').val(JSON.stringify(dataTahap));
    });

    $('#editProgram').submit(function (e) {
        e.preventDefault();
        Swal.fire({
            icon: "question",
            title: "Peringatan",
            text: "Apakah Anda yakin ingin mengubah data program?",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Update",
            confirmButtonColor: "#008080",
            reverseButtons: true,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'ajax',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `${site_url}/back/program/${referensi.id}`,
                    // data: $('#detailProgram').serialize(),
                    // data: {

                    // },
                    data: new FormData($('#editProgram')[0]),
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    // beforeSend: function () { },
                    success: function (response) {
                        // console.log(response);
                        if ((response.status === 'error')) {
                            Swal.fire('Gagal!', 'Aplikasi gagal terhubung dengan server. Silahkan hubungi admin.', 'error');
                        }
                        if (response.status == 'success') {
                            Swal.fire('Update Berhasil!', response.message, 'success').then(function () {
                                location.href = site_url+'/back/program';
                            })
                        }
                    },
                    error: function (xmlhttprequest, textstatus, message) {
                        // text status value : abort, error, parseerror, timeout
                        // default xmlhttprequest = xmlhttprequest.responseJSON.message

                        Swal.fire('Gagal!', xmlhttprequest.responseJSON.message, 'error');
                        // console.log(xmlhttprequest.responseJSON);
                    },
                });
            }
        });
    });

    // function updateDate(id, mulai, selesai){
    //     Swal.fire({
    //         icon: "question",
    //         title: "Peringatan",
    //         text: "Apakah Anda yakin ingin mengubah data tahap program?",
    //         showCancelButton: true,
    //         cancelButtonText: "Batal",
    //         confirmButtonText: "Simpan",
    //         confirmButtonColor: "#008080",
    //         reverseButtons: true,
    //     }).then((result) => {
    //         if (result.value) {
    //             $.ajax({
    //                 type: 'ajax',
    //                 method: 'POST',
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 },
    //                 url: `${site_url}/back/program/date-tahap-program/${referensi.id}`,
    //                 data: {
    //                     id : id,
    //                     mulai : mulai,
    //                     selesai : selesai,
    //                 },
    //                 // contentType: false,
    //                 // processData: false,
    //                 dataType: 'json',
    //                 // beforeSend: function () { },
    //                 success: function (response) {
    //                     // console.log(response);
    //                     if ((response.status === 'error')) {
    //                         Swal.fire('Gagal!', 'Aplikasi gagal terhubung dengan server. Silahkan hubungi admin.', 'error');
    //                     }
    //                     if (response.status == 'success') {
    //                         Swal.fire('Update Berhasil!', response.message, 'success').then(function () {
    //                             // location.href = site_url+'/program';
    //                         })
    //                     }
    //                 },
    //                 error: function (xmlhttprequest, textstatus, message) {
    //                     // text status value : abort, error, parseerror, timeout
    //                     // default xmlhttprequest = xmlhttprequest.responseJSON.message

    //                     Swal.fire('Gagal!', xmlhttprequest.responseJSON.message, 'error');
    //                     // console.log(xmlhttprequest.responseJSON);
    //                 },
    //             });
    //         }
    //     });
    // }
</script>
@endsection    