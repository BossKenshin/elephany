<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elephany | Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

@include(('teacher.tools.subject_modal'))

    <div class="container-fluid">
        <div class="row">
        @include(('teacher.sidebar'))
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h5 mt-4">Subject Dashboard</h1>
                </div>
                <div class="row">
                
                <div class="container mt-5">
    
    <div class="mb-3 text-sm">
        <!-- <button id="addButton" class="btn btn-primary" >Add</button> -->

        <button id="addButton" class="btn btn-primary shadow" data-toggle="modal" data-target="#subjectModal"><i class="bi bi-plus-circle-fill"></i></button>
        <button id="refreshButton" class="btn btn-secondary shadow"><i class="bi bi-arrow-clockwise"></i></button>
    </div>
    <div class="contrainer p-4 border rounded small">

    <table id="subjectTable" class="table table-sm table-striped table-bordered rounded" style="width:100%">
        <thead>
            <tr>
                <th>Subject ID</th>
                <th>Name</th>
                <th>Learners</th>
                <th>Lessons</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           
            <!-- Add more rows as needed -->
        </tbody>
    </table>

    </div>
    
</div>
                


                </div>
            </main>
        </div>
        
    </div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    $(document).ready(function() {
        var table = $('#subjectTable').DataTable(
            {
                "columnDefs": [
                {
                    "targets": 0, // The index of the column to hide (0 is the first column)
                    "visible": false
                },
                {
                    "targets": 4, // The index of the column to change width (4 is the last column)
                    "width": "150px"// Set the desired width here
                },
                
            ]
            }
        );
        
        

    // Initialize DataTable

    // Function to load subjects
   async function loadSubjects() {

        $('#refreshButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

        await new Promise(resolve => setTimeout(resolve, 2000));

        
     await axios.get('/api/subjects')
            .then(response => {
                table.clear();
            // Check if subjects are present
            if (response.data.subject) {
                // Add new data
                response.data.subject.forEach(subject => {
                    table.row.add([
                        subject.id,
                        subject.name,
                        Math.floor(Math.random() * (100 - 0 + 1)) + 0,
                        Math.floor(Math.random() * (120 - 10 + 1)) + 10,
                        `<button class="btn btn-sm btn-primary btnInfo"><i class="bi bi-info-circle"></i></button>
                        <button class="btn btn-sm btn-danger btnDelete"><i class="bi bi-trash"></i></button>`
                    ]);
                });
            } 

            $('#refreshButton').html('<i class="bi bi-arrow-clockwise"></i>');

            // Draw the table
            table.draw();
            })
            .catch(error => {
                console.error('Error loading subjects:', error);
            });
    }

    // Load subjects on page load
    loadSubjects();


                $('#refreshButton').on('click', async function() {
                // Display the spinner
                       await loadSubjects();

                // Replace the spinner with the arrow icon
            });

        // $('#addButton').on('click', function() {
        //     // Example of refreshing the table

        //     Swal.fire({
        //     title: "Name of Subject",
        //     input: "text",
        //     inputAttributes: {
        //         autocapitalize: "off"
        //     },
        //     showCancelButton: true,
        //     confirmButtonText: "Save Subject",
        //     showLoaderOnConfirm: true,
        //     preConfirm: async (subjectName) => {
        //         if (!subjectName) {
        //         Swal.fire({
        //             icon: "error",
        //             title: "Subject Name Required",
        //             text: "Please enter a name for the subject.",
        //         });
        //         throw new Error("Subject Name Required");
        //     }


        //         try {
        //             axios.post('/api/create/subject', { name: subjectName })
        //     .then(response => {

        //         if (!response.ok) {
                
        //             loadSubjects();

        //         }
        //         else{
        //             console.log(response);
        //             Swal.fire({
        //             icon: "error",
        //             title: "Something went wrong",
        //             text: response.data.response,
        //         });
        //         }

        //         // Reload subjects
        //     })
        //     .catch(error => {
        //         console.error('Error adding subject:', error);
        //     });
        //         } catch (error) {
        //         Swal.showValidationMessage(`
        //             Request failed: ${error}
        //         `);
        //         }
        //     },
        //     allowOutsideClick: () => !Swal.isLoading()
        //     }).then((result) => {
        //     if (result.isConfirmed) {
        //         Swal.fire({
        //         position: "top-end",
        //         icon: "success",
        //         title: "Your work has been saved",
        //         showConfirmButton: false,
        //         timer: 1500
        //         });
        //     }
        //     });        
        // });





        $('#subjectForm').on('submit', function(event) {
        event.preventDefault();

        const subjectName = $('#subjectForm #subjectName').val();

        Swal.fire({
            title: "Save this subject?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                axios.post('/api/create/subject', { name: subjectName })
            .then(response => {

                console.log(response);
                // Close the modal
                $('#subjectModal').modal('hide');
                // Clear the form
                $('#subjectForm')[0].reset();
                // Reload subjects


                if(response.data.success == true){
                    Swal.fire("Subject Saved!", "", "success");

                }
                
                loadSubjects();



            })
            .catch(error => {
                Swal.fire("Subject is not saved", error, "info");
            });
                
            } else if (result.isDenied) {
                Swal.fire("Subject is not saved", "", "info");
            }
            });
    });


    $('#subjectFormUpdate').on('submit', function(event) {
    event.preventDefault();

    let subjectName = $('#subjectFormUpdate #subjectName').val();
    let subjectId = $('#subjectFormUpdate #subjectId').val();

    Swal.fire({
        title: "Update this subject?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Update",
        denyButtonText: `Don't save`
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post('/api/edit/subject', { name: subjectName, id: subjectId })
                .then(response => {
                    // Close the modal
                    $('#subjectModalUpdate').modal('hide');

                    // Clear the form
                    $('#subjectFormUpdate')[0].reset();

                    if (response.data.success) {
                        Swal.fire("Subject Updated!", "", "success");
                        loadSubjects();
                    } else {
                        Swal.fire("Subject Update failed", response.data.message || "Unknown error", "error");
                    }
                })
                .catch(error => {
                    console.error('Error during axios post:', error);
                    Swal.fire("Subject is not saved", error.message || "Unknown error", "info");
                });
        } else if (result.isDenied) {
            Swal.fire("Subject is not saved", "", "info");
        }
    });
});


    $('#subjectTable').on('click', '.btnDelete', function() {
    // Handle button click here
    var row = $(this).closest('tr'); // Get the closest row to the clicked button

    var rowData = table.row($(this).closest('tr')).data();
    
    // Get the data of the hidden column (column 0)
    var id = rowData[0]; // Assuming column 0 contains the ID



                Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {

                axios.get('/api/delete/subject/'+id)
            .then(response => {

                console.log(response);
                row.remove(); // Remove the row from the table
                Swal.fire({
                title: "Deleted!",
                text: "Your subject has been deleted.",
                icon: "success"
                });

                loadSubjects();


            })
            .catch(error => {
                console.log(error);
                Swal.fire("Failed to delete", "", "info");
            });

          
            }
            });

  });


  $('#subjectTable').on('click', '.btnInfo', function() {
    // Handle button click here
    var row = $(this).closest('tr'); // Get the closest row to the clicked button

    var rowData = table.row($(this).closest('tr')).data();
    
    // Get the data of the hidden column (column 0)
    var id = rowData[0]; // Assuming column 0 contains the ID
    var name = rowData[1]; // Assuming column 0 contains the ID

    $('#subjectModalUpdate #subjectName').val(name);
    $('#subjectModalUpdate #subjectId').val(id);

    $('#subjectModalUpdate').modal('show');

  });

    });
</script>

</body>

</html>