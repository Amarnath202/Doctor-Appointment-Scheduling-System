🏥 Doctor Appointment Scheduling System

A full-stack healthcare appointment scheduling system that allows administrators, doctors, and patients to seamlessly manage healthcare services.

🔹 Features

Admin Panel
Create and manage doctors
Create and manage patients
Manage doctor sessions and availability

Doctor Module
View assigned patients and appointments
Manage personal profile and availability

Patient Module
Register & manage profile
Book, reschedule, or cancel appointments
View upcoming sessions with favorite doctors

Appointment Scheduling
Real-time session booking
Prevents double booking
Easy session management for doctors and patients

🔹 Tech Stack

Frontend: HTML, CSS, JavaScript (or React if you used it)
Backend: PHP (with MySQL database)
Database: MySQL (hospital_db)
Other Tools: Git, XAMPP/WAMP (for local development)

🔹 Database Schema (Main Tables)

doctor → Stores doctor details (name, specialization, experience, etc.)
patient → Stores patient details
session → Manages doctor availability sessions
appointment → Tracks patient bookings

🔹 Future Enhancements
Role-based authentication with JWT/Session management
Email/SMS notifications for appointments
Search & filter doctors by specialization/location
Analytics dashboard for admins and doctors

[Edoc](https://github.com/HashenUdara/edoc-doctor-appointment-system/) is a Simple web project that is made for e-channeling Using PHP,HTML & CSS.
This initiative facilitates online appointment requests for clients or patients of medical establishments, including clinics and hospitals. This project can also help doctors to manage their appointment with their patients. This doctor's appointment system will organize the schedules of each patient's appointment, which will be submitted as a request to the doctor they have selected. The system comprises three key roles: administrator, doctor, and patient. The system admin will populate the list of the doctors with their specialties and along with the doctor's details and system credentials. The patients can browse the doctor's appointment system website to find a doctor that has the specialty of their needs. Patients can review the doctor's weekly schedule, enabling them to select a suitable day and time for their appointment. Subsequently, they can submit their appointment request. After that, the doctors can view all their appointments and the appointment request of the patients for their availability.


## Features

### Admin
  
- Admin can add doctors, edit doctors, delete doctors    
- Schedule new doctors sessions, remove sessions   
- View patients details    
- View booking of patients    
    
    
 
 
### Doctors

- View their Appointment
- View their scheduled sessions
- View details of patients
- Delete account    
- Eedit account settings
    

    
### Patiens(Clients)
  
  - Make appointment online
  - Create accounts themslves
  - View their old booking
  - Delete account
  - Edit account settings    


-----------------------------------------------


# GET STARTED (Run the Project)

1. Open your XAMPP Control Panel and start Apache and MySQL.
2. Extract the downloaded source code zip file.
3. Copy the extracted source code folder and paste it into the XAMPP's "htdocs" directory.
4. Browse the PHPMyAdmin in a browser. i.e. http://localhost/phpmyadmin
5. Create a new database naming `edoc`.
6. Import the provided SQL file. The file is known as DATABASE edoc.sql located inside the source code root folder.
7. Browse the Doctor's Appointment Systsem in a browser. i.e. http://localhost/edoc-echanneling-main/.


# The Project was developed using the following:

Apache Version: 	`2.4.39`

PHP Version: 		`7.3.5`

Server Software: 	`Apache/2.4.39 (Win64) PHP/7.3.5`

MySQL Version: 		`5.7.26`

Demo video: https://drive.google.com/file/d/17Tv46Eh497lQK63gxin0ES0V5RRMlBXy/view?usp=sharing




