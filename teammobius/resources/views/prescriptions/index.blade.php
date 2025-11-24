@extends('layouts.app')

@section('title', 'Prescriptions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Patient Prescriptions</h3>
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addPrescriptionModal">
                        <i class="fas fa-plus"></i> Add New Prescription
                    </button>
                </div>
                <div class="card-body">
                    <!-- Patient Information Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Patient Information</h5>
                            <div class="form-group">
                                <label for="patientSelect">Select Patient:</label>
                                <select class="form-control" id="patientSelect">
                                    <option value="">-- Select Patient --</option>
                                    <!-- Patients will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clinicianNotes">Clinician Notes:</label>
                                <textarea class="form-control" id="clinicianNotes" rows="4" placeholder="Enter clinical observations, diagnosis, and treatment notes..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Prescriptions List -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="prescriptionsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medication Name</th>
                                    <th>Dosage</th>
                                    <th>Instructions</th>
                                    <th>Quantity</th>
                                    <th>Date Prescribed</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Prescriptions will be populated dynamically -->
                                <tr>
                                    <td colspan="7" class="text-center">No prescriptions found. Add a new prescription to get started.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Prescription Modal -->
<div class="modal fade" id="addPrescriptionModal" tabindex="-1" role="dialog" aria-labelledby="addPrescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPrescriptionModalLabel">Add New Prescription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="prescriptionForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medical_record_id">Medical Record ID *</label>
                                <input type="text" class="form-control" id="medical_record_id" name="medical_record_id" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medication_name">Medication Name *</label>
                                <input type="text" class="form-control" id="medication_name" name="medication_name" required placeholder="e.g., Amoxicillin, Lisinopril">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dosage">Dosage *</label>
                                <input type="text" class="form-control" id="dosage" name="dosage" required placeholder="e.g., 500mg, 10mg">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">Quantity *</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required min="1" placeholder="e.g., 30, 60">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="instructions">Instructions *</label>
                        <textarea class="form-control" id="instructions" name="instructions" rows="4" required placeholder="e.g., Take one tablet twice daily after meals. Complete the full course."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Prescription</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Prescription Modal -->
<div class="modal fade" id="editPrescriptionModal" tabindex="-1" role="dialog" aria-labelledby="editPrescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPrescriptionModalLabel">Edit Prescription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPrescriptionForm">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_prescription_id" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_medical_record_id">Medical Record ID *</label>
                                <input type="text" class="form-control" id="edit_medical_record_id" name="medical_record_id" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_medication_name">Medication Name *</label>
                                <input type="text" class="form-control" id="edit_medication_name" name="medication_name" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_dosage">Dosage *</label>
                                <input type="text" class="form-control" id="edit_dosage" name="dosage" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_quantity">Quantity *</label>
                                <input type="number" class="form-control" id="edit_quantity" name="quantity" required min="1">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_instructions">Instructions *</label>
                        <textarea class="form-control" id="edit_instructions" name="instructions" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Prescription</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission handling would go here
        // This would typically be implemented with AJAX or Livewire
        
        console.log('Prescriptions management page loaded');
        
        // Example of form submission handling (to be implemented based on your backend)
        document.getElementById('prescriptionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // AJAX call to save prescription would go here
            alert('Prescription saved successfully!');
            $('#addPrescriptionModal').modal('hide');
            this.reset();
        });
        
        document.getElementById('editPrescriptionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // AJAX call to update prescription would go here
            alert('Prescription updated successfully!');
            $('#editPrescriptionModal').modal('hide');
        });
    });
    
    // Function to open edit modal (to be implemented based on your data structure)
    function editPrescription(id) {
        // Fetch prescription data and populate edit form
        console.log('Editing prescription with ID: ' + id);
        $('#editPrescriptionModal').modal('show');
    }
    
    // Function to delete prescription
    function deletePrescription(id) {
        if (confirm('Are you sure you want to delete this prescription?')) {
            // AJAX call to delete prescription would go here
            console.log('Deleting prescription with ID: ' + id);
            alert('Prescription deleted successfully!');
        }
    }
</script>
@endsection
