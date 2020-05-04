// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseDescription extends Component {

    static slug = 'tutor_course_description';

    render() {
        return (
            <Fragment>
                <div
                    dangerouslySetInnerHTML={{ __html: this.props.__description }} 
                />
            </Fragment>
        );
    }
}

export default CourseDescription;