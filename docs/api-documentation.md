# Mein Moers API Documentation

This document describes the available APIs in the Mein Moers backend service. The API is used by the iOS and Android mobile applications.

## Base URL

- Production: `https://[your-domain]/api`
- Development: `http://localhost/api`

## API Versions

The API is versioned with two major versions currently available:
- **v1**: Original API endpoints
- **v2**: Enhanced API with additional features

## Authentication

Most endpoints require authentication using JWT (JSON Web Tokens). Include the token in the Authorization header:

```
Authorization: Bearer <your-token>
```

### Authentication Endpoints

#### POST /v2/auth/login
Login to get an access token.

**Request:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "access_token": "eyJ0eXAiOiJKV1...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

#### GET /v2/auth/refresh
Refresh an existing token. Requires authentication.

**Response:**
```json
{
  "access_token": "eyJ0eXAiOiJKV1...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

#### GET /v2/auth/user
Get the authenticated user's information. Requires authentication.

**Response:**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "user@example.com"
}
```

#### POST /v2/auth/logout
Logout and invalidate the token. Requires authentication.

## Events API

### v1 Endpoints

#### GET /v1/events
Get a paginated list of future events.

**Query Parameters:**
- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 30)

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Event Title",
      "description": "Event description",
      "start_date": "2024-01-01T10:00:00Z",
      "end_date": "2024-01-01T12:00:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 100
  }
}
```

#### GET /v1/events/{id}
Get details of a specific event.

**Response:**
```json
{
  "id": 1,
  "title": "Event Title",
  "description": "Event description",
  "start_date": "2024-01-01T10:00:00Z",
  "end_date": "2024-01-01T12:00:00Z",
  "location": "Event Location"
}
```

#### GET /v1/events/overview
Get an overview of events categorized by type (today, featured, long-term).

**Response:**
```json
{
  "today": [...],
  "featured": [...],
  "long_term": [...]
}
```

### v2 Endpoints

#### GET /v2/advEvents
Get advanced events list.

#### GET /v2/advEvents/keyed
Get advanced events list keyed by date.

## Parking API

### v1 Endpoints

#### GET /v1/parking-areas
Get a list of all parking areas.

**Response:**
```json
{
  "data": {
    "parking_areas": [
      {
        "id": 1,
        "name": "Parking Area Name",
        "address": "Street Address",
        "capacity": 100,
        "available_spaces": 50,
        "is_open": true
      }
    ]
  }
}
```

#### GET /v1/parking-areas/{id}
Get details of a specific parking area including past occupancy data.

**Response:**
```json
{
  "data": {
    "parking_area": {
      "id": 1,
      "name": "Parking Area Name",
      "capacity": 100,
      "available_spaces": 50
    },
    "past_occupancy": {
      "max_capacity": 10,
      "data": [
        {
          "hour": 0,
          "occupancy_rate": 0.75
        }
      ]
    }
  }
}
```

#### GET /v1/parking/dashboard
Get parking dashboard data with aggregated information.

## Rubbish Collection API

### v1 Endpoints

#### GET /v1/rubbish/streets
Get a list of streets with rubbish collection information.

**Response:**
```json
{
  "data": [
    {
      "name": "Street Name",
      "id": 1
    }
  ]
}
```

#### GET /v1/rubbish/streets/{street}/pickups
Get pickup dates for a specific street.

**Query Parameters:**
- `street`: Street identifier

**Response:**
```json
{
  "data": [
    {
      "date": "2024-01-01",
      "type": "residual_waste"
    }
  ]
}
```

### v2 Endpoints

#### GET /v2/rubbish/streets
Get a list of streets (v2 endpoint).

#### GET /v2/rubbish/streets/{street}/pickups
Get pickup dates for a specific street (v2 endpoint).

## Organizations API (v2)

All organization endpoints are under `/v2/organisations`.

#### GET /v2/organisations
Get a list of organizations.

#### GET /v2/organisations/{id}
Get details of a specific organization.

#### POST /v2/organisations
Create a new organization.

**Request:**
```json
{
  "name": "Organization Name",
  "description": "Organization description"
}
```

#### PUT /v2/organisations/{id}
Update an organization.

#### DELETE /v2/organisations/{id}
Delete an organization.

### Organization Users

#### GET /v2/organisations/{id}/users
Get users belonging to an organization.

#### POST /v2/organisations/{id}/join
Join an organization. Requires authentication.

#### POST /v2/organisations/{id}/leave
Leave an organization. Requires authentication.

#### POST /v2/organisations/{id}/makeAdmin
Make a user an admin of the organization.

#### POST /v2/organisations/{id}/makeMember
Make a user a regular member of the organization.

#### POST /v2/organisations/{id}/addUser
Add a user to the organization.

#### POST /v2/organisations/{id}/removeUser
Remove a user from the organization.

### Organization Entry

#### GET /v2/organisations/{id}/entry
Get the entry associated with an organization.

#### POST /v2/organisations/{id}/entry
Associate an entry with an organization.

#### DELETE /v2/organisations/{id}/entry
Remove the entry association from an organization.

## Entries API (v1 & v2)

Entries represent general content items or listings.

#### GET /v1/entries
Get a list of entries.

#### POST /v1/entries
Create a new entry.

#### PUT /v1/entries/{id}
Update an entry.

#### GET /v1/entries/{id}/history
Get the change history for an entry.

#### GET /v2/entries
Get a list of entries (v2 endpoint).

#### POST /v2/entries
Create a new entry (v2 endpoint).

#### PUT /v2/entries/{id}
Update an entry (v2 endpoint).

#### GET /v2/entries/{id}/history
Get entry history (v2 endpoint).

## Polls API (v2)

All poll endpoints require authentication.

#### GET /v2/polls
Get a list of polls.

#### GET /v2/polls/{id}
Get details of a specific poll.

#### GET /v2/polls/unanswered
Get polls that the authenticated user hasn't answered yet.

#### GET /v2/polls/answered
Get polls that the authenticated user has already answered.

#### POST /v2/polls
Create a new poll. Requires `create-poll` permission.

**Request:**
```json
{
  "title": "Poll Title",
  "description": "Poll description",
  "options": [
    {"text": "Option 1"},
    {"text": "Option 2"}
  ]
}
```

#### POST /v2/polls/{id}/vote
Vote on a poll.

**Request:**
```json
{
  "option_id": 1
}
```

#### POST /v2/polls/{id}/abstain
Abstain from voting on a poll.

## Groups API (v2)

#### GET /v2/groups
Get a list of groups.

## Radio Broadcasts API (v1)

#### GET /v1/radio-broadcasts
Get a list of radio broadcasts.

#### GET /v1/radio-broadcasts/{id}
Get details of a specific radio broadcast.

## Tracker API (v2)

#### GET /v2/tracker
Get tracker information.

## Admin API (v2)

All admin endpoints are under `/v2/admin` and require:
- Authentication
- `access-admin` permission

### Users

#### GET /v2/admin/users
Get a list of all users. Requires `read-user` permission.

#### GET /v2/admin/users/{id}
Get details of a specific user. Requires `read-user` permission.

#### PUT /v2/admin/users/{id}
Update a user. Requires `read-user` and `update-user` permissions.

#### POST /v2/admin/users/{id}/join
Add a user to a group. Requires `read-user` permission.

#### POST /v2/admin/users/{id}/leave
Remove a user from a group. Requires `read-user` permission.

#### POST /v2/admin/users/{id}/allow/createPoll
Grant a user permission to create polls. Requires `read-user` and `update-user` permissions.

#### POST /v2/admin/users/{id}/disallow/createPoll
Revoke a user's permission to create polls. Requires `read-user` and `update-user` permissions.

### Groups

#### GET /v2/admin/groups
Get a list of all groups. Requires `read-group` permission.

#### GET /v2/admin/groups/{id}
Get details of a specific group. Requires `read-group` permission.

#### PUT /v2/admin/groups/{id}
Update a group. Requires `read-group` and `update-group` permissions.

#### POST /v2/admin/groups/{id}/allowCreatePoll
Grant a group permission to create polls. Requires `read-group` and `update-group` permissions.

#### POST /v2/admin/groups/{id}/disallowCreatePoll
Revoke a group's permission to create polls. Requires `read-group` and `update-group` permissions.

## Error Responses

All endpoints return standard HTTP status codes:

- `200 OK`: Request successful
- `201 Created`: Resource created successfully
- `400 Bad Request`: Invalid request parameters
- `401 Unauthorized`: Authentication required or failed
- `403 Forbidden`: Insufficient permissions
- `404 Not Found`: Resource not found
- `422 Unprocessable Entity`: Validation errors
- `500 Internal Server Error`: Server error

Error responses follow this format:

```json
{
  "message": "Error message",
  "errors": {
    "field": ["Validation error message"]
  }
}
```

## Pagination

Paginated endpoints support the following query parameters:

- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 30, max: 100)

Paginated responses include metadata:

```json
{
  "data": [...],
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 10,
    "per_page": 30,
    "to": 30,
    "total": 300
  },
  "links": {
    "first": "http://example.com/api/v1/events?page=1",
    "last": "http://example.com/api/v1/events?page=10",
    "prev": null,
    "next": "http://example.com/api/v1/events?page=2"
  }
}
```

## Rate Limiting

API requests are rate-limited to prevent abuse. Current limits:
- Authenticated requests: 60 requests per minute
- Unauthenticated requests: 30 requests per minute

Rate limit information is included in response headers:
- `X-RateLimit-Limit`: Maximum requests allowed
- `X-RateLimit-Remaining`: Remaining requests in current window
- `X-RateLimit-Reset`: Timestamp when the limit resets

## API Versioning and Deprecation Policy

### Version Support

- The current major versions (v1 and v2) are fully supported
- Minor updates and bug fixes will not break backward compatibility
- Deprecated endpoints will continue to work for at least 6 months after deprecation notice
- Clients should always specify the API version in the URL path

### Breaking Changes

Breaking changes will only be introduced in new major versions. Examples of breaking changes:
- Removing or renaming endpoints
- Changing required request parameters
- Modifying response structure
- Changing authentication methods

### Deprecation Process

1. Deprecated endpoints will be marked in this documentation
2. Deprecation warnings will be added to API responses via the `X-API-Deprecated` header
3. Email notifications will be sent to registered API users
4. A minimum 6-month notice period will be provided before removal

## Best Practices

1. **Always use HTTPS** in production environments
2. **Cache responses** where appropriate to reduce API calls
3. **Handle rate limits** gracefully with exponential backoff
4. **Validate input** before sending requests
5. **Handle errors** properly with appropriate user feedback
6. **Keep tokens secure** and never expose them in client-side code
7. **Use API versioning** to ensure stability as the API evolves

## Support

For API support, please contact: meinmoers@lambdadigamma.com

For bug reports and feature requests, please use the GitHub issue tracker:
- iOS: https://github.com/LambdaDigamma/moers-ios
- Android: https://github.com/LambdaDigamma/moers-android
- Backend: https://github.com/LambdaDigamma/moers-web

## Changelog

### Current Version
- v1 and v2 APIs are stable and in production use
- Authentication via JWT
- Support for events, parking, rubbish collection, organizations, polls, and admin functions

---

Last updated: December 2024
