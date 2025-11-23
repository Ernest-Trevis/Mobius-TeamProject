Create Database mobius_db;
use database mobius_db;

Create table if not exists Users(
    user_id int auto_increment primary key,
    first_name varchar(255) not null,
    last_name varchar(255) not null,
    email varchar(255) not null unique,
    phone_number int not null,
    user_role varchar(50) not null,
    date_of_birth date not null,
    password_hash varchar(255) not null
);

Create table if not exists Faculty(
    faculty_id int auto_increment primary key,
    doctor_id int references Users(user_id),
    specialty varchar(255) not null,
    license_number varchar(50) not null unique,
    bio text,
    years_of_experience int not null
);

Create table if not exists Appointments(
    appointment_id int auto_increment primary key,
    user_id int refrences Users(user_id),
    faculty_id int references Faculty(faculty_id),
    appointment_date datetime not null,
    appointment_time time not null,
    appointment_status varchar(50) not null,
    notes text
);

Create table if not exists Ratings(
    rating_id int auto_increment primary key,
    faculty_id int references Faculty(faculty_id),
    user_id int references Users(user_id),
    rating int not null,
    created_at datetime default current_timestamp
);

Create table if not exists Feedback(
    feedback_id int auto_increment primary key,
    appointment_id int references Appointments(appointment_id),
    user_id int references Users(user_id),
    faculty_id int references Faculty(faculty_id),
    comments text,
    submitted_at datetime default current_timestamp
);

Create table if not exists MedicalRecords(
    record_id int auto_increment primary key,
    patient_id int references Users(user_id),
    doctor_id  int references Faculty(faculty_id),
    appointment_id int references Appointments(appointment_id),
    diagnosis text,
    prescription text
);

Create table if not exists Payments(
    payment_id int auto_increment primary key,
    patient_id int references Users(user_id),
    appointment_id int references Appointments(appointment_id),
    amount int not null,
    payment_status varchar(255) not null
);

Create table if not exists Notifications(
    notification_id int auto_increment primary key,
    user_id int references Users(user_id),
    title varchar(255) not null,
    notification_type varchar(50) not null,
    is_read boolean default false
);

Create table if not exists Prescriptions(
    prescription_id int auto_increment primary key,
    appointment_id int references Appointments(appointment_id),
    doctor_id int references Faculty(faculty_id),
    patient_id int references Users(user_id),
    medication text not null,
    dosage text not null,
    instructions text not null,
    created_at datetime default current_timestamp
);

Insert into Users (user_id, first_name, last_name, email, phone_number, user_role, date_of_birth, password_hash) 
values ();

Insert into Faculty (faculty_id, doctor_id, specialty, license_number, bio, years_of_experience)
values ();

Insert into Appointments (appointment_id, user_id, faculty_id, appointment_date, appointment_time, appointment_status, notes)
values ();

Insert into Ratings (rating_id, faculty_id, user_id, rating, created_at)
values ();

Insert into Feedback (feedback_id, appointment_id, user_id, faculty_id, comments, submitted_at)
values ();

Insert into MedicalRecords (record_id, patient_id, doctor_id, appointment_id, diagnosis, prescription)
values ();

Insert into Payments (payment_id, patient_id, appointment_id, amount, payment_status)
values ();

Insert into Notifications (notification_id, user_id, title, notification_type, is_read)
values ();

Insert into Prescriptions (prescription_id, appointment_id, doctor_id, patient_id, medication, dosage, instructions, created_at)
values ();

-- Possible queries
Select * from Users;
Select * from Faculty;
Select * from Appointments;
Select * from Ratings;
Select * from Feedback;
Select * from MedicalRecords;
Select * from Payments;
Select * from Notifications;
Select * from Prescriptions;




