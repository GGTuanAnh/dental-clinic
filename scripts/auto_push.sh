#!/usr/bin/env bash
set -euo pipefail

# Auto push script for this project
# Usage: ./scripts/auto_push.sh "commit message"

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$REPO_ROOT"

FILES=("src-tmp/.env" "database/database.sqlite" "Procfile")
MSG="${1:-ci: Railway support - set ABS sqlite path, APP_URL and add sqlite file + Procfile}"

echo "Repo root: $REPO_ROOT"
echo "Files to add: ${FILES[*]}"
echo "Commit message: $MSG"

# Ensure files exist (create if missing)
for f in "${FILES[@]}"; do
  if [ ! -e "$f" ]; then
    echo "Creating missing file: $f"
    mkdir -p "$(dirname "$f")"
    : > "$f"
  fi
done

echo "Staging files..."
git add "${FILES[@]}"

echo "Committing..."
if git commit -m "$MSG"; then
  echo "Commit created." 
else
  echo "No changes to commit." 
fi

echo "Pushing to origin..."
if git push origin HEAD; then
  echo "Push successful.";
else
  echo "Push failed — attempting git pull --rebase and retry..."
  git pull --rebase origin main || { echo "Rebase failed"; exit 1; }
  git push origin HEAD
fi

echo "Done."
