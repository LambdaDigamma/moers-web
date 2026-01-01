# Mein Moers API - Quick Reference

This is a quick reference guide for all available API endpoints in the Mein Moers backend.

For detailed documentation with examples, see [API Documentation](api-documentation.md).

## Base URLs

- **v1**: `/api/v1`
- **v2**: `/api/v2`

## Authentication

| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| POST | `/v2/auth/login` | No | Login and get access token |
| GET | `/v2/auth/refresh` | Yes | Refresh access token |
| GET | `/v2/auth/user` | Yes | Get current user info |
| POST | `/v2/auth/logout` | Yes | Logout and invalidate token |

## Events

| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v1/events` | No | List future events (paginated) |
| GET | `/v1/events/{id}` | No | Get event details |
| GET | `/v1/events/overview` | No | Get categorized events overview |
| GET | `/v2/advEvents` | No | Get advanced events list |
| GET | `/v2/advEvents/keyed` | No | Get advanced events keyed by date |

## Parking

| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v1/parking-areas` | No | List all parking areas |
| GET | `/v1/parking-areas/{id}` | No | Get parking area details with occupancy |
| GET | `/v1/parking/dashboard` | No | Get parking dashboard overview |

## Rubbish Collection

### v1
| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v1/rubbish/streets` | No | List streets with collection service |
| GET | `/v1/rubbish/streets/{street}/pickups` | No | Get pickup schedule for street |

### v2
| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v2/rubbish/streets` | No | List streets (v2) |
| GET | `/v2/rubbish/streets/{street}/pickups` | No | Get pickup schedule (v2) |

## Organizations (v2 only)

### Basic CRUD
| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v2/organisations` | TBD | List organizations |
| GET | `/v2/organisations/{id}` | TBD | Get organization details |
| POST | `/v2/organisations` | TBD | Create organization |
| PUT | `/v2/organisations/{id}` | TBD | Update organization |
| DELETE | `/v2/organisations/{id}` | TBD | Delete organization |

### Organization Users
| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v2/organisations/{id}/users` | TBD | Get organization users |
| POST | `/v2/organisations/{id}/join` | Yes | Join organization |
| POST | `/v2/organisations/{id}/leave` | Yes | Leave organization |
| POST | `/v2/organisations/{id}/makeAdmin` | TBD | Make user admin |
| POST | `/v2/organisations/{id}/makeMember` | TBD | Make user member |
| POST | `/v2/organisations/{id}/addUser` | TBD | Add user to organization |
| POST | `/v2/organisations/{id}/removeUser` | TBD | Remove user from organization |

### Organization Entry
| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v2/organisations/{id}/entry` | TBD | Get associated entry |
| POST | `/v2/organisations/{id}/entry` | TBD | Associate entry |
| DELETE | `/v2/organisations/{id}/entry` | TBD | Remove entry association |

## Entries

### v1
| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v1/entries` | TBD | List entries |
| POST | `/v1/entries` | TBD | Create entry |
| PUT | `/v1/entries/{id}` | TBD | Update entry |
| GET | `/v1/entries/{id}/history` | TBD | Get entry history |

### v2
| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v2/entries` | TBD | List entries |
| POST | `/v2/entries` | TBD | Create entry |
| PUT | `/v2/entries/{id}` | TBD | Update entry |
| GET | `/v2/entries/{id}/history` | TBD | Get entry history |

## Polls (v2 only)

| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v2/polls` | Yes | List all polls |
| GET | `/v2/polls/{id}` | Yes | Get poll details |
| GET | `/v2/polls/unanswered` | Yes | Get unanswered polls |
| GET | `/v2/polls/answered` | Yes | Get answered polls |
| POST | `/v2/polls` | Yes + Permission | Create poll (requires `create-poll`) |
| POST | `/v2/polls/{id}/vote` | Yes | Vote on poll |
| POST | `/v2/polls/{id}/abstain` | Yes | Abstain from poll |

## Groups (v2 only)

| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v2/groups` | TBD | List groups |

## Radio Broadcasts (v1)

| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v1/radio-broadcasts` | No | List radio broadcasts |
| GET | `/v1/radio-broadcasts/{id}` | No | Get broadcast details |

## Tracker (v2)

| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| GET | `/v2/tracker` | TBD | Get tracker data |

## Admin API (v2)

**All admin endpoints require:**
- Authentication (`auth:api` middleware)
- `access-admin` permission

### Admin Users

| Method | Endpoint | Auth Required | Permissions | Description |
|--------|----------|---------------|-------------|-------------|
| GET | `/v2/admin/users` | Yes | `read-user` | List all users |
| GET | `/v2/admin/users/{id}` | Yes | `read-user` | Get user details |
| PUT | `/v2/admin/users/{id}` | Yes | `read-user`, `update-user` | Update user |
| POST | `/v2/admin/users/{id}/join` | Yes | `read-user` | Add user to group |
| POST | `/v2/admin/users/{id}/leave` | Yes | `read-user` | Remove user from group |
| POST | `/v2/admin/users/{id}/allow/createPoll` | Yes | `read-user`, `update-user` | Grant poll creation permission |
| POST | `/v2/admin/users/{id}/disallow/createPoll` | Yes | `read-user`, `update-user` | Revoke poll creation permission |

### Admin Groups

| Method | Endpoint | Auth Required | Permissions | Description |
|--------|----------|---------------|-------------|-------------|
| GET | `/v2/admin/groups` | Yes | `read-group` | List all groups |
| GET | `/v2/admin/groups/{id}` | Yes | `read-group` | Get group details |
| PUT | `/v2/admin/groups/{id}` | Yes | `read-group`, `update-group` | Update group |
| POST | `/v2/admin/groups/{id}/allowCreatePoll` | Yes | `read-group`, `update-group` | Grant group poll permission |
| POST | `/v2/admin/groups/{id}/disallowCreatePoll` | Yes | `read-group`, `update-group` | Revoke group poll permission |

---

**Legend:**
- TBD = Authentication requirements need to be determined by reviewing controller code
- Yes = Authentication required
- No = Public endpoint

**Notes:**
1. All endpoints return JSON responses
2. Paginated endpoints support `page` and `per_page` query parameters
3. Error responses follow standard HTTP status codes (4xx for client errors, 5xx for server errors)
4. Rate limiting applies: 60 req/min (authenticated), 30 req/min (unauthenticated)

For detailed request/response examples and schemas, see the [full API documentation](api-documentation.md) or [OpenAPI specification](openapi.yaml).
