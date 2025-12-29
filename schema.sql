CREATE DATABASE IF NOT EXISTS hospital_db;
USE hospital_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(20) NOT NULL,
  profile_picture VARCHAR(255),
  original_picture_name VARCHAR(255),
  address TEXT,
  registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  department_name VARCHAR(100) NOT NULL UNIQUE,
  description TEXT
);

CREATE TABLE doctors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  department_id INT,
  specialization VARCHAR(100) NOT NULL,
  bio TEXT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (department_id) REFERENCES departments(id)
);

CREATE TABLE patients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  date_of_birth DATE,
  gender VARCHAR(10),
  blood_group VARCHAR(5),
  address TEXT,
  emergency_contact VARCHAR(20),
  medical_history TEXT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  reason TEXT,
  status VARCHAR(20) DEFAULT 'pending',
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (patient_id) REFERENCES patients(id),
  FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);

CREATE TABLE medicines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  medicine_name VARCHAR(100) NOT NULL UNIQUE,
  generic_name VARCHAR(100),
  category VARCHAR(50),
  description TEXT,
  manufacturer VARCHAR(100),
  unit_price DECIMAL(10,2) NOT NULL,
  stock_quantity INT DEFAULT 0,
  reorder_level INT DEFAULT 10,
  expiry_date DATE
);

CREATE TABLE prescriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  appointment_id INT,
  diagnosis VARCHAR(255) NOT NULL,
  instructions TEXT,
  follow_up_date DATE,
  created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (patient_id) REFERENCES patients(id),
  FOREIGN KEY (doctor_id) REFERENCES doctors(id),
  FOREIGN KEY (appointment_id) REFERENCES appointments(id)
);

CREATE TABLE prescription_medicines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  prescription_id INT NOT NULL,
  medicine_name VARCHAR(100) NOT NULL,
  dosage VARCHAR(50) NOT NULL,
  frequency VARCHAR(50) NOT NULL,
  duration VARCHAR(50) NOT NULL,
  FOREIGN KEY (prescription_id) REFERENCES prescriptions(id)
);

CREATE TABLE medical_records (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  record_type VARCHAR(50) NOT NULL,
  description TEXT NOT NULL,
  file_path VARCHAR(255),
  record_date DATE NOT NULL,
  uploaded_by INT NOT NULL,
  upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (patient_id) REFERENCES patients(id),
  FOREIGN KEY (uploaded_by) REFERENCES users(id)
);

CREATE TABLE bills (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  appointment_id INT,
  total_amount DECIMAL(10,2) NOT NULL,
  discount DECIMAL(5,2) DEFAULT 0,
  tax DECIMAL(5,2) DEFAULT 0,
  paid_amount DECIMAL(10,2) DEFAULT 0,
  notes TEXT,
  created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (patient_id) REFERENCES patients(id),
  FOREIGN KEY (appointment_id) REFERENCES appointments(id)
);

CREATE TABLE bill_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bill_id INT NOT NULL,
  item_description VARCHAR(255) NOT NULL,
  quantity INT DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (bill_id) REFERENCES bills(id)
);

CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bill_id INT NOT NULL,
  payment_amount DECIMAL(10,2) NOT NULL,
  payment_method VARCHAR(50) NOT NULL,
  transaction_id VARCHAR(100),
  payment_notes TEXT,
  payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  received_by INT NOT NULL,
  FOREIGN KEY (bill_id) REFERENCES bills(id),
  FOREIGN KEY (received_by) REFERENCES users(id)
);

CREATE TABLE rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  room_number VARCHAR(20) NOT NULL UNIQUE,
  room_type VARCHAR(50) NOT NULL,
  floor VARCHAR(20),
  capacity INT DEFAULT 1,
  price_per_day DECIMAL(10,2) NOT NULL,
  facilities TEXT,
  description TEXT,
  status VARCHAR(20) DEFAULT 'Available'
);

CREATE TABLE room_assignments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  room_id INT NOT NULL,
  admission_date DATE NOT NULL,
  discharge_date DATE,
  expected_discharge_date DATE,
  admission_notes TEXT,
  assigned_by INT NOT NULL,
  FOREIGN KEY (patient_id) REFERENCES patients(id),
  FOREIGN KEY (room_id) REFERENCES rooms(id),
  FOREIGN KEY (assigned_by) REFERENCES users(id)
);

CREATE TABLE notices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  category VARCHAR(50) NOT NULL,
  content TEXT NOT NULL,
  is_important TINYINT DEFAULT 0,
  expiry_date DATE,
  posted_by INT NOT NULL,
  posted_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (posted_by) REFERENCES users(id)
);

CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  type VARCHAR(50) NOT NULL,
  message TEXT NOT NULL,
  link VARCHAR(255),
  status VARCHAR(20) DEFAULT 'unread',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(100) NOT NULL UNIQUE,
  setting_value TEXT
);



INSERT INTO users (full_name, email, phone, username, password, role, address) VALUES
('Admin', 'admin@hospital.com', '01712345678', 'admin', 'admin123', 'admin', 'Dhaka, Bangladesh');

INSERT INTO users (full_name, email, phone, username, password, role, address) VALUES
('MD. TOKY TAJWER MAHIN', 'toky.mahin@hospital.com', '01712345679', 'dr.toky', 'pass123', 'doctor', 'Dhaka, Bangladesh'),
('PRITHILA RANI SAHA', 'prithila.saha@hospital.com', '01712345680', 'dr.prithila', 'pass123', 'doctor', 'Dhaka, Bangladesh'),
('MOSTOFA ZAKARIA', 'mostofa.zakaria@hospital.com', '01712345681', 'dr.mostofa', 'pass123', 'doctor', 'Dhaka, Bangladesh'),
('MARUF AHMED', 'maruf.ahmed@hospital.com', '01712345682', 'dr.maruf', 'pass123', 'doctor', 'Dhaka, Bangladesh'),
('SUMAIYA AMIRUN', 'sumaiya.amirun@hospital.com', '01712345683', 'dr.sumaiya', 'pass123', 'doctor', 'Dhaka, Bangladesh'),
('MAHEDY HASAN', 'mahedy.hasan@hospital.com', '01712345684', 'dr.mahedy', 'pass123', 'doctor', 'Dhaka, Bangladesh'),
('MD. EHSANUL HAQUE', 'ehsanul.haque@hospital.com', '01712345685', 'dr.ehsanul', 'pass123', 'doctor', 'Dhaka, Bangladesh'),
('MIR FARHANA JARIN ALAM', 'farhana.alam@hospital.com', '01712345686', 'dr.farhana', 'pass123', 'doctor', 'Dhaka, Bangladesh');

INSERT INTO users (full_name, email, phone, username, password, role, address) VALUES
('ARPITA SAHA ARPA', 'arpita.arpa@email.com', '01812345679', 'arpita.arpa', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('AONYENDO PAUL NETEISH', 'aonyendo.paul@email.com', '01812345680', 'aonyendo.paul', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('NOWRIN BINTA RASHID', 'nowrin.rashid@email.com', '01812345681', 'nowrin.rashid', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('NAZAT E ROSE RHYTHM', 'nazat.rhythm@email.com', '01812345682', 'nazat.rhythm', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('PROGGA PAROMITA DAS', 'progga.das@email.com', '01812345683', 'progga.das', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('FARJANA JAHAN SNIGDHA', 'farjana.snigdha@email.com', '01812345684', 'farjana.snigdha', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('ZANNATUL FERDOUS NIJHUM', 'zannatul.nijhum@email.com', '01812345685', 'zannatul.nijhum', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('SHARMIN AKTER NUPOR', 'sharmin.nupor@email.com', '01812345686', 'sharmin.nupor', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('MD. IBRAHIM TANJIM', 'ibrahim.tanjim@email.com', '01812345687', 'ibrahim.tanjim', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('ABDULLAH FARHAN', 'abdullah.farhan@email.com', '01812345688', 'abdullah.farhan', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('ABDULLAH AL NAYEEM', 'abdullah.nayeem@email.com', '01812345689', 'abdullah.nayeem', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('MOSADDIK AL TAWSIF', 'mosaddik.tawsif@email.com', '01812345690', 'mosaddik.tawsif', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('MD TANVIR RAHMAN', 'tanvir.rahman@email.com', '01812345691', 'tanvir.rahman', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('MD AKIB HOSSAIN', 'akib.hossain@email.com', '01812345692', 'akib.hossain', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('AKIB HASAN PYIL', 'akib.pyil@email.com', '01812345693', 'akib.pyil', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('MOST. SUMAIYA HABIBA NISHAT', 'sumaiya.nishat@email.com', '01812345694', 'sumaiya.nishat', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('CHAYAN ADHIKARY', 'chayan.adhikary@email.com', '01812345695', 'chayan.adhikary', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('MD.SHOHAN MOLLA', 'shohan.molla@email.com', '01812345696', 'shohan.molla', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('FAHIMA SULTANA SMRITY', 'fahima.smrity@email.com', '01812345697', 'fahima.smrity', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('M. ABDULLAH KHAN', 'abdullah.khan@email.com', '01812345698', 'm.abdullah', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('DEWAN HASIBUL KARIM', 'hasibul.karim@email.com', '01812345699', 'hasibul.karim', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('MAHDI HASSAN NOOR ASIF', 'mahdi.asif@email.com', '01812345700', 'mahdi.asif', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('KHALED MD RAIHAN', 'khaled.raihan@email.com', '01812345701', 'khaled.raihan', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('SYEDAHANAF CHOWDHURY AUDITTA', 'hanaf.auditta@email.com', '01812345702', 'hanaf.auditta', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('MD. ZOBAYER HOSEN', 'zobayer.hosen@email.com', '01812345703', 'zobayer.hosen', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('ZUNAID ZIHAN', 'zunaid.zihan@email.com', '01812345704', 'zunaid.zihan', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('EFRATH HOSSAIN SHIHAB', 'efrath.shihab@email.com', '01812345705', 'efrath.shihab', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('JOY DEBNATH', 'joy.debnath@email.com', '01812345706', 'joy.debnath', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('MD. GALIB SHAHRIAR SHOPNIL', 'galib.shopnil@email.com', '01812345707', 'galib.shopnil', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('LAMIA TAHSIN', 'lamia.tahsin@email.com', '01812345708', 'lamia.tahsin', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('RASHNA RAHMAN RICHITA', 'rashna.richita@email.com', '01812345709', 'rashna.richita', 'pass123', 'patient', 'Dhaka, Bangladesh'),
('SANIA AKTER', 'sania.akter@email.com', '01812345710', 'sania.akter', 'pass123', 'patient', 'Dhaka, Bangladesh');

INSERT INTO departments (department_name, description) VALUES
('Cardiology', 'Heart and cardiovascular system specialists'),
('Neurology', 'Brain and nervous system specialists'),
('Orthopedics', 'Bone, joint, and muscle specialists'),
('Pediatrics', 'Children healthcare specialists'),
('General Medicine', 'General healthcare and diagnosis'),
('Surgery', 'Surgical procedures and operations'),
('Gynecology', 'Women health specialists'),
('Dermatology', 'Skin and hair specialists');

INSERT INTO doctors (user_id, department_id, specialization, bio) VALUES
(2, 1, 'Cardiologist', 'Specialized in heart diseases and cardiac care'),
(3, 2, 'Neurologist', 'Expert in brain and nervous system disorders'),
(4, 3, 'Orthopedic Surgeon', 'Specialized in bone and joint surgery'),
(5, 4, 'Pediatrician', 'Children healthcare specialist'),
(6, 5, 'General Physician', 'General medicine and primary care'),
(7, 6, 'General Surgeon', 'Expert in surgical procedures'),
(8, 7, 'Gynecologist', 'Women health and maternity specialist'),
(9, 8, 'Dermatologist', 'Skin, hair and cosmetic specialist');

INSERT INTO patients (user_id, date_of_birth, gender, blood_group, address, emergency_contact, medical_history) VALUES
(10, '1998-05-15', 'Female', 'A+', 'Dhaka, Bangladesh', '01912345678', 'No major illness'),
(11, '1999-08-22', 'Male', 'B+', 'Dhaka, Bangladesh', '01912345679', 'Asthma'),
(12, '2000-03-10', 'Female', 'O+', 'Dhaka, Bangladesh', '01912345680', 'No major illness'),
(13, '1997-11-30', 'Female', 'AB+', 'Dhaka, Bangladesh', '01912345681', 'Allergies'),
(14, '1998-07-18', 'Female', 'A-', 'Dhaka, Bangladesh', '01912345682', 'No major illness'),
(15, '1999-02-25', 'Female', 'B+', 'Dhaka, Bangladesh', '01912345683', 'Diabetes'),
(16, '2000-09-14', 'Female', 'O-', 'Dhaka, Bangladesh', '01912345684', 'No major illness'),
(17, '1998-12-05', 'Female', 'A+', 'Dhaka, Bangladesh', '01912345685', 'Hypertension'),
(18, '1999-06-20', 'Male', 'B-', 'Dhaka, Bangladesh', '01912345686', 'No major illness'),
(19, '2000-01-08', 'Male', 'AB-', 'Dhaka, Bangladesh', '01912345687', 'No major illness'),
(20, '1997-10-12', 'Male', 'O+', 'Dhaka, Bangladesh', '01912345688', 'No major illness'),
(21, '1998-04-28', 'Male', 'A+', 'Dhaka, Bangladesh', '01912345689', 'No major illness'),
(22, '1999-11-16', 'Male', 'B+', 'Dhaka, Bangladesh', '01912345690', 'No major illness'),
(23, '2000-07-03', 'Male', 'O+', 'Dhaka, Bangladesh', '01912345691', 'No major illness'),
(24, '1998-03-19', 'Male', 'A-', 'Dhaka, Bangladesh', '01912345692', 'No major illness'),
(25, '1999-09-27', 'Female', 'B+', 'Dhaka, Bangladesh', '01912345693', 'No major illness'),
(26, '2000-05-11', 'Male', 'O-', 'Dhaka, Bangladesh', '01912345694', 'No major illness'),
(27, '1997-12-24', 'Male', 'AB+', 'Dhaka, Bangladesh', '01912345695', 'No major illness'),
(28, '1998-08-07', 'Female', 'A+', 'Dhaka, Bangladesh', '01912345696', 'No major illness'),
(29, '1999-04-15', 'Male', 'B-', 'Dhaka, Bangladesh', '01912345697', 'No major illness'),
(30, '2000-10-02', 'Male', 'O+', 'Dhaka, Bangladesh', '01912345698', 'No major illness'),
(31, '1998-06-18', 'Male', 'A+', 'Dhaka, Bangladesh', '01912345699', 'No major illness'),
(32, '1999-02-09', 'Male', 'AB-', 'Dhaka, Bangladesh', '01912345700', 'No major illness'),
(33, '2000-08-26', 'Female', 'B+', 'Dhaka, Bangladesh', '01912345701', 'No major illness'),
(34, '1997-05-13', 'Male', 'O-', 'Dhaka, Bangladesh', '01912345702', 'No major illness'),
(35, '1998-11-29', 'Male', 'A-', 'Dhaka, Bangladesh', '01912345703', 'No major illness'),
(36, '1999-07-06', 'Male', 'B+', 'Dhaka, Bangladesh', '01912345704', 'No major illness'),
(37, '2000-03-23', 'Male', 'O+', 'Dhaka, Bangladesh', '01912345705', 'No major illness'),
(38, '1998-09-17', 'Male', 'AB+', 'Dhaka, Bangladesh', '01912345706', 'No major illness'),
(39, '1999-05-04', 'Female', 'A+', 'Dhaka, Bangladesh', '01912345707', 'No major illness'),
(40, '2000-12-21', 'Female', 'B-', 'Dhaka, Bangladesh', '01912345708', 'No major illness'),
(41, '1997-08-08', 'Female', 'O+', 'Dhaka, Bangladesh', '01912345709', 'No major illness');

INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, reason, status, notes) VALUES
(1, 1, '2024-12-30', '10:00:00', 'Heart checkup', 'confirmed', 'Regular checkup'),
(2, 2, '2024-12-30', '11:00:00', 'Headache consultation', 'confirmed', 'Persistent headaches'),
(3, 3, '2024-12-31', '09:00:00', 'Knee pain', 'pending', 'Sports injury'),
(4, 4, '2024-12-31', '10:30:00', 'Child vaccination', 'confirmed', 'Routine vaccination'),
(5, 5, '2025-01-02', '14:00:00', 'Fever and cough', 'pending', 'Cold symptoms'),
(6, 6, '2025-01-02', '15:00:00', 'Pre-surgery consultation', 'confirmed', 'Appendix removal'),
(7, 7, '2025-01-03', '11:00:00', 'Pregnancy checkup', 'confirmed', 'Second trimester'),
(8, 8, '2025-01-03', '16:00:00', 'Skin rash', 'pending', 'Allergic reaction'),
(9, 1, '2025-01-04', '10:00:00', 'Follow-up', 'confirmed', 'Post-treatment checkup'),
(10, 2, '2025-01-04', '11:30:00', 'MRI review', 'pending', 'Brain scan results');

INSERT INTO medicines (medicine_name, generic_name, category, description, manufacturer, unit_price, stock_quantity, reorder_level, expiry_date) VALUES
('Napa', 'Paracetamol', 'Painkiller', 'For fever and pain relief', 'Beximco Pharmaceuticals', 2.50, 1000, 100, '2025-12-31'),
('Sergel', 'Sertraline', 'Antidepressant', 'For depression and anxiety', 'Square Pharmaceuticals', 15.00, 500, 50, '2025-06-30'),
('Seclo', 'Omeprazole', 'Antacid', 'For gastric problems', 'Square Pharmaceuticals', 5.00, 800, 80, '2025-09-30'),
('Fexo', 'Fexofenadine', 'Antihistamine', 'For allergies', 'Square Pharmaceuticals', 8.00, 600, 60, '2025-08-31'),
('Ace', 'Paracetamol', 'Painkiller', 'Pain and fever relief', 'Beximco Pharmaceuticals', 3.00, 900, 90, '2025-11-30');

INSERT INTO prescriptions (patient_id, doctor_id, appointment_id, diagnosis, instructions, follow_up_date) VALUES
(1, 1, 1, 'Mild hypertension', 'Take medicine twice daily, reduce salt intake', '2025-01-15'),
(2, 2, 2, 'Migraine', 'Avoid stress, take prescribed medicine', '2025-01-20'),
(4, 4, 4, 'Routine vaccination', 'No special instructions', NULL);

INSERT INTO prescription_medicines (prescription_id, medicine_name, dosage, frequency, duration) VALUES
(1, 'Ace', '500mg', 'Twice daily', '30 days'),
(2, 'Sergel', '50mg', 'Once daily', '15 days'),
(2, 'Napa', '500mg', 'As needed', '7 days');

INSERT INTO rooms (room_number, room_type, floor, capacity, price_per_day, facilities, description, status) VALUES
('101', 'General Ward', '1', 4, 500.00, 'AC, TV, Bathroom', 'General ward with 4 beds', 'Available'),
('201', 'Private', '2', 1, 2000.00, 'AC, TV, Bathroom, WiFi', 'Private room with single bed', 'Available'),
('202', 'Private', '2', 1, 2000.00, 'AC, TV, Bathroom, WiFi', 'Private room with single bed', 'Occupied'),
('301', 'ICU', '3', 1, 5000.00, 'AC, Ventilator, Monitoring', 'Intensive care unit', 'Available'),
('302', 'ICU', '3', 1, 5000.00, 'AC, Ventilator, Monitoring', 'Intensive care unit', 'Occupied');

INSERT INTO room_assignments (patient_id, room_id, admission_date, expected_discharge_date, admission_notes, assigned_by) VALUES
(5, 3, '2024-12-28', '2025-01-05', 'Post-surgery recovery', 1),
(10, 5, '2024-12-29', '2025-01-10', 'Critical condition monitoring', 1);

INSERT INTO notices (title, category, content, is_important, expiry_date, posted_by) VALUES
('Hospital Closed on New Year', 'Holiday', 'The hospital will be closed on January 1st, 2025. Only emergency services available.', 1, '2025-01-01', 1),
('New Cardiologist Joined', 'Staff', 'Dr. Toky Tajwer Mahin has joined our cardiology department.', 0, NULL, 1),
('Health Checkup Camp', 'Event', 'Free health checkup camp on January 15, 2025.', 1, '2025-01-15', 1);

INSERT INTO settings (setting_key, setting_value) VALUES
('hospital_name', 'City Hospital'),
('hospital_address', '123 Street, Dhaka, Bangladesh'),
('hospital_phone', '01712345678'),
('hospital_email', 'info@cityhospital.com'),
('hospital_website', 'www.cityhospital.com');
