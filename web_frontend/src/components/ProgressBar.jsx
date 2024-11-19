import React from 'react';

const ProgressBar = ({ currentTime, duration, onSeek }) => {
    const handleInputChange = (e) => {
        const newTime = parseFloat(e.target.value);
        onSeek(newTime);
    };

    const formatTime = (time) => {
        const minutes = Math.floor(time / 60);
        const seconds = Math.floor(time % 60).toString().padStart(2, '0');
        return `${minutes}:${seconds}`;
    };

    return (
        <div className="progress-container">
            <span>{formatTime(currentTime)}</span>
            <input
                type="range"
                min="0"
                max={duration}
                value={currentTime}
                onChange={handleInputChange}
                className="progress-bar"
            />
            <span>{formatTime(duration)}</span>
        </div>
    );
};

export default ProgressBar;
