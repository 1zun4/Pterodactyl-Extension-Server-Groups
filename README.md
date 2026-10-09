# Server Groups for Pterodactyl

[![Release](https://img.shields.io/github/v/release/1zun4/Pterodactyl-Extension-Server-Groups?style=flat-square)](https://github.com/1zun4/Pterodactyl-Extension-Server-Groups/releases/latest)
[![Downloads](https://img.shields.io/github/downloads/1zun4/Pterodactyl-Extension-Server-Groups/total?style=flat-square)](https://github.com/1zun4/Pterodactyl-Extension-Server-Groups/releases)
[![Pterodactyl](https://img.shields.io/badge/Pterodactyl-2.0-0e4688?style=flat-square)](https://pterodactyl.io)
[![License](https://img.shields.io/github/license/1zun4/Pterodactyl-Extension-Server-Groups?style=flat-square)](LICENSE)

Group servers, colour them on the dashboard and give a team access to a whole group at once.

![Admin groups](docs/screenshots/admin.png)

## Install

1. Download `server-groups-<version>.pteroext` from the [latest release](https://github.com/1zun4/Pterodactyl-Extension-Server-Groups/releases/latest).
2. Install and enable it under **Admin → Extensions**.
3. Create your first group under **Admin → Server Groups**.

## Features

- **Team access**: group members become subusers of every server in the group, with a preset (Full access, Operator, Console only, Read only) or custom permissions.
- **Safe sync**: only subusers the extension created are changed or removed. Subusers added by hand stay as they are.
- **Dashboard badges**: users see the groups of their servers next to each server.
- **Account page**: **Account → Server Groups** lists a user's servers by group.
- **Admin column**: the admin server list shows each server's groups.

![Group editor](docs/screenshots/editor.png)

![Dashboard badges](docs/screenshots/dashboard.png)

Access is synced on every save, with **Sync now**, and once a day (`php artisan server-groups:sync`).

---

Inspired by the Pelican plugin Server Groups.
