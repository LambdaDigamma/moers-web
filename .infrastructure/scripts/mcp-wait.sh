#!/usr/bin/env bash
#
# Retry wrapper for commands that depend on Docker or other services.
# Filters stdout to pass only JSON-RPC messages, stripping startup noise
# (ANSI codes, container messages, emoji banners) that would corrupt the
# MCP stdio protocol. Retries on failure until the service is available.
#
# Usage: mcp-wait.sh COMMAND [ARGS...]

MAX_RETRIES=60
SLEEP_SECONDS=5
attempt=0

while [ $attempt -lt $MAX_RETRIES ]; do
    # stdout: pass only JSON-RPC lines (strips ANSI codes, emoji banners)
    # stderr: suppress docker-compose container lifecycle messages
    "$@" 2>/dev/null | grep --line-buffered '^{'
    exit_code="${PIPESTATUS[0]}"

    # Exit if:
    # 1. Success (exit code 0)
    # 2. Signal termination (exit code > 128)
    [ "$exit_code" -eq 0 ] && exit 0
    [ "$exit_code" -gt 128 ] && exit "$exit_code"

    attempt=$((attempt + 1))
    echo "mcp-wait: attempt $attempt/$MAX_RETRIES failed (exit $exit_code), retrying in ${SLEEP_SECONDS}s..." >&2
    sleep "$SLEEP_SECONDS"
done

echo "mcp-wait: gave up after $MAX_RETRIES attempts: $*" >&2
exit 1

