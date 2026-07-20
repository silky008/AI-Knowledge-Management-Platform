# Database Design

## Users Table

Purpose:
Stores application users.

Fields:

| Field      | Type      | Description        |
| ---------- | --------- | ------------------ |
| id         | bigint    | Primary key        |
| name       | varchar   | User name          |
| email      | varchar   | Login email        |
| password   | varchar   | Encrypted password |
| created_at | timestamp | Creation time      |
| updated_at | timestamp | Last update        |
