<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head -->
    <?php $this->load->view('partial/activities/head.php') ?>

    <!-- Additional Style (Global) -->
    <style type="text/css">
    </style>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <!-- Sidebar -->
        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper py-4 px-4 text-sm">
            <div class="">
                <div class="row mb-2">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <button class="btn btn-sm btn-danger mr-1">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <button class="btn btn-sm btn-success">
                                <i class="fas fa-file-export"></i> Export
                            </button>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-secondary" id="btnAdd">
                                <i class="fas fa-plus"></i> New
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card card-outline card-secondary mb-0">
                    <!-- <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user"></i> Customer</h3>
                    </div> -->
                    <div class="card-body py-2 px-2 border-bottom">
                        <form>
                            <!-- ROW 1 -->
                            <div class="row">
                                <!-- Show -->
                                <div class="col-md-2">
                                    <label class="mb-1">Show</label>
                                    <select class="form-control form-control-sm">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                    </select>
                                </div>
                                <!-- Province -->
                                <div class="col-md-3">
                                    <label class="mb-1">Province</label>
                                    <select class="form-control form-control-sm">
                                        <option value="">All</option>
                                        <option>Jawa Barat</option>
                                        <option>Jawa Tengah</option>
                                        <option>Jawa Timur</option>
                                    </select>
                                </div>
                                <!-- City -->
                                <div class="col-md-3">
                                    <label class="mb-1">City</label>
                                    <select class="form-control form-control-sm">
                                        <option value="">All</option>
                                        <option>Bandung</option>
                                        <option>Jakarta</option>
                                        <option>Surabaya</option>
                                    </select>
                                </div>
                                <!-- Search -->
                                <div class="col-md-4">
                                    <label class="mb-1">Search</label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Name, email, phone...">
                                </div>
                                <div class="col-md-12 mt-2 d-flex justify-content-end">
                                    <div class="d-flex">
                                        <button type="button" class="btn px-3 mr-1 btn-sm btn-secondary">
                                            <i class="fas fa-undo"></i> Reset
                                        </button>
                                        <button type="button" class="btn px-3 btn-sm btn-primary mr-1">
                                            <i class="fas fa-check"></i> Apply
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <table id="" class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Province</th>
                                <th>City</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Andi Saputra</td>
                                <td>081234567001</td>
                                <td>andi@gmail.com</td>
                                <td>Jawa Barat</td>
                                <td>Bandung</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary btn-edit" data-name="Andi Saputra"
                                        data-phone="081234567001" data-email="andi@gmail.com" data-province="Jawa Barat"
                                        data-city="Bandung">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger btn-delete" data-name="Andi Saputra">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Budi Santoso</td>
                                <td>081234567002</td>
                                <td>budi@gmail.com</td>
                                <td>Jawa Tengah</td>
                                <td>Semarang</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Citra Lestari</td>
                                <td>081234567003</td>
                                <td>citra@gmail.com</td>
                                <td>DKI Jakarta</td>
                                <td>Jakarta</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Dewi Anggraini</td>
                                <td>081234567004</td>
                                <td>dewi@gmail.com</td>
                                <td>Jawa Timur</td>
                                <td>Surabaya</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Eko Prasetyo</td>
                                <td>081234567005</td>
                                <td>eko@gmail.com</td>
                                <td>DIY</td>
                                <td>Yogyakarta</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Fajar Nugroho</td>
                                <td>081234567006</td>
                                <td>fajar@gmail.com</td>
                                <td>Jawa Barat</td>
                                <td>Bekasi</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Gita Permata</td>
                                <td>081234567007</td>
                                <td>gita@gmail.com</td>
                                <td>Jawa Tengah</td>
                                <td>Solo</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Hendra Wijaya</td>
                                <td>081234567008</td>
                                <td>hendra@gmail.com</td>
                                <td>Banten</td>
                                <td>Tangerang</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Indah Sari</td>
                                <td>081234567009</td>
                                <td>indah@gmail.com</td>
                                <td>Sumatera Utara</td>
                                <td>Medan</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Joko Susilo</td>
                                <td>081234567010</td>
                                <td>joko@gmail.com</td>
                                <td>Jawa Timur</td>
                                <td>Malang</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>Kiki Amelia</td>
                                <td>081234567011</td>
                                <td>kiki@gmail.com</td>
                                <td>Jawa Barat</td>
                                <td>Bogor</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Lukman Hakim</td>
                                <td>081234567012</td>
                                <td>lukman@gmail.com</td>
                                <td>Kalimantan Timur</td>
                                <td>Samarinda</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Maya Putri</td>
                                <td>081234567013</td>
                                <td>maya@gmail.com</td>
                                <td>Sumatera Barat</td>
                                <td>Padang</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Nanda Saputri</td>
                                <td>081234567014</td>
                                <td>nanda@gmail.com</td>
                                <td>Riau</td>
                                <td>Pekanbaru</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Oki Pratama</td>
                                <td>081234567015</td>
                                <td>oki@gmail.com</td>
                                <td>Jawa Tengah</td>
                                <td>Magelang</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Putri Ayu</td>
                                <td>081234567016</td>
                                <td>putri@gmail.com</td>
                                <td>Bali</td>
                                <td>Denpasar</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Rizky Maulana</td>
                                <td>081234567017</td>
                                <td>rizky@gmail.com</td>
                                <td>Jawa Barat</td>
                                <td>Cirebon</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Siti Nurhaliza</td>
                                <td>081234567018</td>
                                <td>siti@gmail.com</td>
                                <td>Aceh</td>
                                <td>Banda Aceh</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Taufik Hidayat</td>
                                <td>081234567019</td>
                                <td>taufik@gmail.com</td>
                                <td>Sulawesi Selatan</td>
                                <td>Makassar</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Yuni Kartika</td>
                                <td>081234567020</td>
                                <td>yuni@gmail.com</td>
                                <td>Kalimantan Barat</td>
                                <td>Pontianak</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-xs btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="card-footer px-2 py-2">
                        <div class="row align-items-center">
                            <!-- Info -->
                            <div class="col-md-6">
                                <div class="dataTables_info font-italic ">
                                    Showing 1 to 10 of 57 entries
                                </div>
                            </div>
                            <!-- Pagination -->
                            <div class="col-md-6">
                                <nav>
                                    <ul class="pagination pagination-sm justify-content-end mb-0">

                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">First</a>
                                        </li>

                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">Prev</a>
                                        </li>

                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>

                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>

                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>

                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>

                                        <li class="page-item">
                                            <a class="page-link" href="#">6</a>
                                        </li>

                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>

                                        <li class="page-item">
                                            <a class="page-link" href="#">Last</a>
                                        </li>

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modall Add/Edit -->
        <div class="modal fade" id="modalForm" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Customer</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="formCustomer">

                            <div class="form-group">
                                <label>Fullname</label>
                                <input type="text" id="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" id="phone" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email" class="form-control">
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Province</label>
                                        <input type="text" id="province" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" id="city" class="form-control">
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" id="btnSave">Save</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <!-- Foot (js/library) -->
    <?php $this->load->view('partial/activities/foot.php') ?>

    <script>
        $(function () {

            let mode = 'add'
            let currentRow = null

            const modal = $('#modalForm')
            const form = $('#formCustomer')

            const fields = {
                name: $('#name'),
                phone: $('#phone'),
                email: $('#email'),
                province: $('#province'),
                city: $('#city')
            }

            const getValues = () => ({
                name: fields.name.val(),
                phone: fields.phone.val(),
                email: fields.email.val(),
                province: fields.province.val(),
                city: fields.city.val()
            })

            const setValues = (data) => {
                Object.keys(fields).forEach(key => fields[key].val(data[key] || ''))
            }

            const resetForm = () => form[0].reset()

            const renderRow = (data) => `
        <tr>
            <td>${data.name}</td>
            <td>${data.phone}</td>
            <td>${data.email}</td>
            <td>${data.province}</td>
            <td>${data.city}</td>
            <td class="text-right">
                <button class="btn btn-xs btn-outline-primary btn-edit"
                    data-name="${data.name}"
                    data-phone="${data.phone}"
                    data-email="${data.email}"
                    data-province="${data.province}"
                    data-city="${data.city}">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-xs btn-outline-danger btn-delete"
                    data-name="${data.name}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `

            $('#btnAdd').on('click', () => {
                mode = 'add'
                currentRow = null
                $('#modalTitle').text('Add Customer')
                resetForm()
                modal.modal('show')
            })

            $(document).on('click', '.btn-edit', function () {
                const btn = $(this)
                mode = 'edit'
                currentRow = btn.closest('tr')

                $('#modalTitle').text('Edit Customer')

                setValues({
                    name: btn.data('name'),
                    phone: btn.data('phone'),
                    email: btn.data('email'),
                    province: btn.data('province'),
                    city: btn.data('city')
                })

                modal.modal('show')
            })

            $('#btnSave').on('click', () => {
                const data = getValues()

                if (mode === 'add') {
                    $('tbody').prepend(renderRow(data))
                    Swal.fire('Success', 'Data berhasil ditambahkan', 'success')
                } else {
                    currentRow.find('td:eq(0)').text(data.name)
                    currentRow.find('td:eq(1)').text(data.phone)
                    currentRow.find('td:eq(2)').text(data.email)
                    currentRow.find('td:eq(3)').text(data.province)
                    currentRow.find('td:eq(4)').text(data.city)

                    currentRow.find('.btn-edit').data(data)

                    Swal.fire('Success', 'Data berhasil diupdate', 'success')
                }

                modal.modal('hide')
            })

            $(document).on('click', '.btn-delete', function () {
                const row = $(this).closest('tr')
                const name = $(this).data('name')

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: name,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33'
                }).then(res => {
                    if (res.isConfirmed) {
                        row.remove()
                        Swal.fire('Deleted!', 'Data berhasil dihapus.', 'success')
                    }
                })
            })

        })
    </script>
</body>

</html>