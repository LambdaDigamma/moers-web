#!/usr/bin/env bash
#
# Retry wrapper for commands that depend on Docker or other services.
# Unlike the original implementation, this leaves stdout/stderr untouched
# so it works for both MCP stdio traffic and normal CLI commands.
#
# Usage: mcp-wait.sh COMMAND [ARGS...]

set -u

MAX_RETRIES="${MCP_WAIT_MAX_RETRIES:-5}"
SLEEP_SECONDS="${MCP_WAIT_SLEEP_SECONDS:-5}"
attempt=0

while [ "$attempt" -lt "$MAX_RETRIES" ]; do
    "$@"
    exit_code=$?

    if [ "$exit_code" -eq 0 ]; then
        exit 0
    fi

    if [ "$exit_code" -gt 128 ]; then
        exit "$exit_code"
    fi

    attempt=$((attempt + 1))
    echo "mcp-wait: attempt $attempt/$MAX_RETRIES failed (exit $exit_code), retrying in ${SLEEP_SECONDS}s..." >&2
    sleep "$SLEEP_SECONDS"
done

echo "mcp-wait: gave up after $MAX_RETRIES attempts: $*" >&2
exit 1
