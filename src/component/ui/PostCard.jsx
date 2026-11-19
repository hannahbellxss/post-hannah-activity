import React from 'react';
import './styles/post-card.css';

export default function PostCard({ post }) {
    const formattedDate = post.created_at
        ? new Intl.DateTimeFormat('en-US', {
            month: '2-digit',
            day: '2-digit',
            year: 'numeric',
        }).format(new Date(post.created_at))
        : 'Just now';

    return (
        <div className="post-item">
            <div className="post-content">
                <div className="post-header">
                    <span className="post-username">
                        {post.user?.name || 'Guest User'}
                    </span>

                    <small className="post-timestamp">
                        {formattedDate}
                    </small>
                </div>

                <p className="post-message">{post.message}</p>
            </div>
        </div>
    );
}