# Volleyball Club Management System

## Overview
This project is a comprehensive database solution for managing a youth volleyball club called MYVC. It includes all necessary components for managing club members, personnel, locations, teams, sessions, payments, and family associations. The project ensures full data integrity using a range of constraints, triggers, and relational schemas, along with SQL queries and test scripts for system validation.

## Key Features
- **Normalized Schema** (3NF and BCNF where applicable)
- **Data Integrity Enforcement** using advanced MySQL triggers
- **Support for Primary and Secondary Family Members**
- **Team Formation and Game/Training Scheduling**
- **Automated Deactivation of Members** when they age out or don’t pay fees
- **Email Logging** for system communications (e.g., session notifications, deactivations)
- **Comprehensive Test Script** to validate all trigger and constraint functionality

## Structure
- `ClubMember`, `FamilyMember`, `Personnel` tables
- Associative entities for location assignments and roles
- Session and team structures with constraints for gender, time conflicts, location alignment
- Payment tracking per membership year
- Read-only queries for generating operational reports (e.g., active players, payment status)

## Requirements Met
- All age, location, and gender constraints for players
- Unique SIN and Medicare numbers enforced across personnel types
- Email notification tracking and validation
- Capacity and payment validations per location and year
- Session conflict checks

## Conclusion
This project successfully implements a robust, scalable, and rules-compliant database management system for a volleyball club. It ensures that data consistency, integrity, and real-world constraints are respected and enforced entirely within the database layer, minimizing errors and improving overall data governance.

## Author
Developed as part of an academic project to demonstrate relational modeling, SQL trigger design, and business logic enforcement in MySQL.

## License
MIT License


