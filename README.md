#  Movie Ticket Booking System  

## Project Overview

This project is a **Movie Ticket Booking System** built using **Laravel** with **real-time seat management**, **role-based access control**, and **email notifications**.  
It allows customers to browse movies, select showtimes, book seats in real-time, and receive notifications.  
Managers and Admins can confirm or cancel bookings via an interactive dashboard.

This project was developed as part of the **assessment task** assigned by **Kriscent Techno Hub Pvt. Ltd.**

---

## Key Features

### Customer Side
- Browse available **movies** and **showtimes**
- Select seats using an interactive layout (built with **Tailwind + Blade**)
- **Real-time seat updates** using **Pusher + Laravel Echo**
- Automatic seat lock (`pending`) during booking to prevent conflicts
- Email notifications on successful booking (to customer, manager, and admin)
- View booking status and history (upcoming module)

###  Manager / Admin Side
- Manage all bookings (confirm, cancel, or view details)
- Real-time update of seat status across customers’ browsers
- View all theatres, screens, movies, and seat layouts
- Role-based permissions using **Spatie Laravel Permission**
- Booking status updates automatically broadcasted to all connected users
- Dashboard with filtering, search, and pagination

---

## ⚙️ Tech Stack

| Category | Technology Used |
|-----------|-----------------|
| Framework | **Laravel 12** |
| Frontend | **Blade (Tailwind CSS)**, **Bootstrap Icons** |
| Authentication | **Laravel Breeze** |
| Roles & Permissions | **Spatie Laravel Permission** |
| Realtime Updates | **Pusher + Laravel Echo** |
| Notifications | **Laravel Notifications + Queues** |
| Database | **MySQL / MariaDB** |
| Queue Driver | **Database / Redis** (optional) |
| Mail | **Mailtrap / SMTP** for testing |

---

## Architecture Summary

- **Models:**
  - `Movie`, `Theatre`, `Screen`, `Show`, `Seat`, `Booking`, `BookingSeat`
- **Roles:**
  - `Admin` — Full access to all modules and system configuration  
  - `Manager` — Manage bookings for assigned theatres  
  - `Customer` — Book seats and manage their reservations
- **Policies:**  
  Used for authorization (Admin/Manager/Customer specific access)
  - `BookingPolicy` — for viewing, confirming, and cancelling bookings
- **Events / Broadcasting:**
  - `BookingUpdatedEvent` → triggers Pusher updates to all connected users
- **Notifications:**
  - `SeatBookedNotification` — sent to Admins, Managers, and Customers
  - Uses queue jobs for faster response times

---

## Real-Time Booking Flow

1. Customer selects available seats (green).  
2. When seat is clicked → status changes to **pending (yellow)** and broadcasted using **Pusher**.  
3. Admin/Manager receives an email + sees it in dashboard.  
4. Admin/Manager can **confirm (green)** or **cancel (red)** the booking.  
5. All connected users see the seat status update live via **WebSocket events**.

---

##  Installation Guide
composer install
npm install && npm run build
