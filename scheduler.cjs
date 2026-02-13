/**
 * Simple scheduler runner for testbench.
 *
 */
const { execSync } = require("child_process");
const path = require("path");

const INTERVAL = 60_000; // 1 minute for sync with uptime

const isVendor = __dirname.includes(path.join("vendor", "cachethq", "core"));
const projectRoot = isVendor
    ? path.resolve(__dirname, "..", "..", "..") 
    : __dirname;                                
const command = isVendor
    ? "php artisan schedule:run --no-interaction 2>&1"
    : "php vendor/bin/testbench schedule:run --no-interaction 2>&1";

function runSchedule() {
    try {
        execSync(command, {
            stdio: "inherit",
            cwd: projectRoot,
        });
    } catch (e) {
        console.error("[scheduler] Error running schedule:", e);}
}

console.log(`[scheduler] Starting scheduler in every ${INTERVAL}sec...`);

runSchedule();
setInterval(runSchedule, INTERVAL);
