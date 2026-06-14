#!/bin/bash
# ZHIDI Tech — Development Server
# Starts PHP's built-in web server for local testing.
# Usage: bash start.sh
# Then visit: http://localhost:8080

PORT=${1:-8080}
DIR="$(cd "$(dirname "$0")" && pwd)"

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  ZHIDI Tech — Dev Server"
echo "  http://localhost:$PORT"
echo "  Admin: http://localhost:$PORT/admin"
echo "  Press Ctrl+C to stop"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

php -S localhost:$PORT -t "$DIR"
